<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Libraries\General;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Segment;
use App\Models\Admin\Category;
use App\Models\Admin\Company;
use App\Models\Admin\ProductSegment;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductCompany;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }

        if ($request->ajax()) {

            $db_prefix = env('DB_PREFIX');
            $productList = Product::select(
                '*',
            );
            if (!empty($request->get('startDate')) && !empty($request->get('endDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $productList->whereBetween(DB::RAW('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$startDate, $endDate]);
            }
            if (!empty($request->get('startDate')) && empty($request->get('endDate'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $productList->whereDate('created_at', '>=', $startDate);
            }
            if (!empty($request->get('endDate')) && empty($request->get('startDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $productList->whereDate('created_at', '<=', $endDate);
            }
            $productList->whereNull('deleted_at');
            $productList = $productList;
            return Datatables::of($productList)
                ->editColumn('created_at', function ($productList) {
                    //return $productList->created_at->diffForHumans();
                    return $productList->created_at->format('d-m-Y');
                })
                ->filterColumn('created_at', function ($query, $keyword) use ($productList) {
                    $query->whereRaw('DATE_FORMAT(created_at, "%d-%m-%Y") LIKE ?', ["%{$keyword}%"]);
                })
                ->toJson();
        }
        return view('admin.product.product_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }

        //Fetch intial data for add/edit page
        $data = self::initData();
        $product = $data['product'];
        $country_list = $data['country_list'];
        $segment_list = $data['segment_list'];
        $category_list = $data['category_list'];
        $company_list = $data['company_list'];
        return view('admin.product.product_add', compact('product', 'country_list', 'segment_list', 'category_list',  'company_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $requestData = $request->validated();
            $requestData['created_by'] = Auth::guard('admin')->id();
            DB::transaction(function () use ($requestData) {
                $product_id = Product::createOrUpdateProduct($requestData, '');
                //self::insertOrUpdateSegments($product_id, $requestData['product_segments']);
                //self::insertOrUpdateCategories($product_id, $requestData['product_categories']);
                self::insertOrUpdateCompanies($product_id, $requestData['product_companies']);
            }, 1);
            return redirect()->route('admin.products.index')->with('success', 'Product is added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        return view('admin.product.product_add', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        //$novel->load('chapters', 'bookmarks');
        //$product->load('product_segments');
        //$product = Product::with(['product_segments']);
        //$product->product_segments
        //product_segments
        //Fetch intial data for add/edit page
        $data = self::initData();
        $country_list = $data['country_list'];
        $segment_list = $data['segment_list'];
        $category_list = $data['category_list'];
        $company_list = $data['company_list'];
        return view('admin.product.product_add', compact('product', 'country_list', 'segment_list', 'category_list', 'company_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $requestData = $request->validated();
            $requestData['updated_by'] = Auth::guard('admin')->id();
            DB::transaction(function () use ($requestData, $product) {
                $product_id = Product::createOrUpdateProduct($requestData, $product->product_id);
                //self::insertOrUpdateSegments($product_id, $requestData['product_segments']);
                //self::insertOrUpdateCategories($product_id, $requestData['product_categories']);
                self::insertOrUpdateCompanies($product_id, $requestData['product_companies']);
            }, 1);

            return redirect()->route('admin.products.index')->with('success', 'Product is updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message'   => 'Access denied for this action.'
            ], 200);
        }
        try {
            DB::transaction(function () use ($id) {
                Product::destroy($id);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => 'Product is deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'   => 'Something went wrong.'
            ], 200);
        }
    }

    public function multipleDelete(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message'   => 'Access denied for this action.'
            ], 200);
        }
        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                Product::destroy($postData['ids']);
            }, 1);
            //Product::whereIn('product_id', $postData['ids'])->delete();
            return response()->json([
                'success' => true,
                'message'   => 'Products are deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'   => 'Something went wrong.'
            ], 200);
        }
    }

    public function multipleChangeStatus(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message'   => 'Access denied for this action.'
            ], 200);
        }
        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                $status = ($postData['status'] == "active") ? 1 : 0;
                //Find and update multiple users status
                Product::whereIn('product_id', $postData['ids'])->update(['status' => $status]);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => "Status is updated successfully."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'   => 'Something went wrong.'
            ], 200);
        }
    }

    public function changeStatus(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message'   => 'Access denied for this action.'
            ], 200);
        }

        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                $sliderImageObj = Product::findOrFail($postData['id']);
                $status = ($sliderImageObj->status == 1) ? 0 : 1;
                //Update page status
                $sliderImageObj->update(['status' => $status]);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => 'Status is updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'   => 'Something went wrong.'
            ], 200);
        }
    }

    public static function initData()
    {
        $product = new Product();
        $country_list = General::countryList();
        $segment_list = Segment::select('segment_id', 'segment_name')->where('status', 1)->get();
        $category_list = Category::select('category_id', 'category_name')->where('status', 1)->get();
        $company_list = Company::select('company_id', 'company_name')->where('status', 1)->get();
        return compact('country_list', 'product', 'segment_list', 'category_list', 'company_list');
    }

    public static function insertOrUpdateSegments(string $product_id, array $product_segments = [])
    {
        $product_segments_saved = false;
        $productSegmentData = [];
        $productCategory = ProductSegment::where('product_id', $product_id);
        if (!empty($productCategory)) {
            $productCategory->delete();
        }

        foreach ($product_segments as $segment_id) {
            $productSegmentData[] = [
                'product_segment_id' => Str::uuid(),
                'product_id' => $product_id,
                'segment_id' => $segment_id,
                'created_at' => Carbon::now()
            ];
        }

        if (!empty($productSegmentData)) {
            $product_segments_saved = ProductSegment::createManyProductSegments($productSegmentData);
        }

        return $product_segments_saved;
    }

    public static function insertOrUpdateCategories(string $product_id, array $product_categories = [])
    {
        $product_categories_saved = false;
        $productCategoryData = [];
        $productCategory = ProductCategory::where('product_id', $product_id);
        if (!empty($productCategory)) {
            $productCategory->delete();
        }

        foreach ($product_categories as $category_id) {
            $productCategoryData[] = [
                'product_category_id' => Str::uuid(),
                'product_id' => $product_id,
                'category_id' => $category_id,
                'created_at' => Carbon::now()
            ];
        }

        if (!empty($productCategoryData)) {
            $product_categories_saved = ProductCategory::createManyProductCategories($productCategoryData);
        }

        return $product_categories_saved;
    }

    public static function insertOrUpdateCompanies(string $product_id, array $product_companies = [])
    {
        $product_companies_saved = false;
        $productCompaniesData = [];
        $productCompany = ProductCompany::where('product_id', $product_id);
        if (!empty($productCompany)) {
            $productCompany->delete();
        }

        foreach ($product_companies as $company_id) {
            $productCompaniesData[] = [
                'product_company_id' => Str::uuid(),
                'product_id' => $product_id,
                'company_id' => $company_id,
                'created_at' => Carbon::now()
            ];
        }

        if (!empty($productCompaniesData)) {
            $product_companies_saved = ProductCompany::createManyProductCompanies($productCompaniesData);
        }

        return $product_companies_saved;
    }

    public static function dumpProduct()
    {
        $failedProductList = [];
        $productList =
            [
                ['product_name' => 'Beta Carotene 1% CWS -NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 5% CWS - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 10% CWS - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 20% CWS Red - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 20% TG - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 30% OS - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Lycopene 6% TG - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Lycopene 10% CWS - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Lycopene 10% OS - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Lycopene 10% TG - NI', 'principal' => 'Allied Biotech', 'country' => 'Taiwan', 'category_id' => 2],
                ['product_name' => 'Astaxanthin 1% Liquid CWS (N)', 'principal' => 'BGG', 'country' => 'China', 'category_id' => 2],
                ['product_name' => 'Astaxanthin 3% Beadlets (N)', 'principal' => 'BGG', 'country' => 'Japan', 'category_id' => 2],
                ['product_name' => 'Astaxanthin Powder (N) SD 2-5%', 'principal' => 'BGG', 'country' => 'China', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 1% CWS - Synthetic', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 1% CWS - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 5% CWS - Beadlets - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 20% - Powder - NI', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 20% CWS - Beadlets - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 20% OS (Olive) - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Beta Carotene 30% OS (Sunflower) - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lutein 5% - Powder & Beadlets', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lutein 10% - Beadlets', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lutein 20% - Powder', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lutein Ester 10% - Beadlets', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lutein Ester 15% - Oil Suspension', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lycopene 5% - Powder & Beadlets - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lycopene 10% - Beadlets - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Lycopene 20% - Powder - N', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
                ['product_name' => 'Mixed Betacarotenoids 7.5%', 'principal' => 'Lycored', 'country' => 'Israel', 'category_id' => 2],
            ];

        foreach ($productList as $product) {
            $productObject = Product::where('products.product_name', $product['product_name'])
                ->where('products.principal', trim($product['principal']))
                ->where('products.country', trim($product['country']))
                ->first();
            if (!empty($productObject)) {
                $product_id = $productObject->product_id;
            } else {
                $requestData = [
                    'product_name' => trim($product['product_name']),
                    'principal' => trim($product['principal']),
                    'country' => trim($product['country']),
                    'created_by' => 1,
                    'updated_by' => 1
                ];
                $product_id = Product::createOrUpdateProduct($requestData, '');
            }
            $isCategoryExists = ProductCategory::where('product_id', $product_id)
                ->where('category_id', $product['category_id'])
                ->exists();

            if (!$isCategoryExists) {
                $productCategoryData = [
                    'product_category_id' => Str::uuid(),
                    'product_id' => $product_id,
                    'category_id' => $product['category_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ];
                ProductCategory::create($productCategoryData);
            }
        }
    }

    public static function dumpProductWithCompanies()
    {
        ini_set('max_execution_time', 0);
        $failedProductList = [];
        $productList =
            [
                /* ['product_name' => 'BASE FOR CHOCOLATE MIX(HK-MB)', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'CHEESE POWDER CODE 300712', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'CHEESE SEASONING FLAVOR POWDER', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'CHOCOLATE AROMATIC CHEMICALS :HCM', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'CHOCOLATE FLAVOR MFD', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'COCONUT 053620', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'FAT POWDER 70%', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'FLAVOUR EMULSION (GHAT MANGO CODE VKE)', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'MALT BASED CHOCOLATE DRINK', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'MIST REGULAR', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'MIST SUPREME', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'SOFT DRINK CONCENTRATE CLEAR MASALA LIQUID', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'SOFT DRINK CONCENTRATE JALJIRA LIQUID', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'],
                ['product_name' => 'SOFT DRINK CONCENTRATE MIX', 'company_id' => '27d4bf20-8c51-11ed-9591-141877b0c981'], */];

        foreach ($productList as $product) {
            $productObject = Product::where('products.product_name', $product['product_name'])->first();
            if (!empty($productObject)) {
                $product_id = $productObject->product_id;
            } else {
                $requestData = [
                    'product_name' => trim($product['product_name']),
                    'principal' => NULL,
                    'country' => NULL,
                    'created_by' => 1,
                    'updated_by' => 1
                ];
                $product_id = Product::createOrUpdateProduct($requestData, '');
            }
            $isCompanyExists = ProductCompany::where('product_id', $product_id)
                ->where('company_id', $product['company_id'])
                ->exists();

            if (!$isCompanyExists) {
                $productCompaniesData = [
                    'product_company_id' => Str::uuid(),
                    'product_id' => $product_id,
                    'company_id' => $product['company_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => NULL
                ];
                ProductCompany::create($productCompaniesData);
            }
        }
    }
}
