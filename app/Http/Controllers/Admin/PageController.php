<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Admin\Page;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
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
            $pageList = Page::select(
                '*',
                //DB::RAW('DATE_FORMAT(created_at, "%d-%m-%Y") as createdAt'),
                DB::RAW('IF(' . $db_prefix . 'pages.is_static="1", "Dynamic", "Static") as is_static')
            );
            if (!empty($request->get('startDate')) && !empty($request->get('endDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $pageList->whereBetween(DB::RAW('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$startDate, $endDate]);
            }
            if (!empty($request->get('startDate')) && empty($request->get('endDate'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $pageList->whereDate('created_at', '>=', $startDate);
            }
            if (!empty($request->get('endDate')) && empty($request->get('startDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $pageList->whereDate('created_at', '<=', $endDate);
            }
            $pageList->whereNull('deleted_at');
            $pageList = $pageList;
            return Datatables::of($pageList)
                ->editColumn('description', function ($pageList) {
                    if (isset($pageList->description) && $pageList->description != "") {
                        return html_entity_decode(strip_tags($pageList->description));
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($pageList) {
                    //return $pageList->created_at->diffForHumans();
                    return $pageList->created_at->format('d-m-Y');
                })
                ->filterColumn('created_at', function ($query, $keyword) use ($pageList) {
                    $query->whereRaw('DATE_FORMAT(created_at, "%d-%m-%Y") LIKE ?', ["%{$keyword}%"]);
                })
                ->filterColumn('is_static', function ($query, $keyword) use ($pageList, $db_prefix) {
                    $query->whereRaw('IF(' . $db_prefix . 'pages.is_static="1", "Dynamic", "Static") LIKE ?', ["%{$keyword}%"]);
                })
                ->toJson();
        }
        return view('admin.page.page_list');
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
        return view('admin.page.page_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request, ImageService $imageService)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $fileData = "";
            $requestData = $request->validated();
            $requestData['created_by'] = Auth::guard('admin')->id();
            if ($request->hasFile('page_header_image')) {
                $fileData = $imageService->handleFileUpload('page_images', $request->file('page_header_image'), '', 'public');
                $requestData['page_header_image'] = $fileData;
            }
            DB::transaction(function () use ($requestData) {
                Page::createOrUpdatePage($requestData, '');
            }, 1);
            return redirect()->route('admin.pages.index')->with('success', 'Page is added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        return view('admin.page.page_add', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page, ImageService $imageService)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $fileData = $page->page_header_image;
            $requestData = $request->validated();
            $requestData['updated_by'] = Auth::guard('admin')->id();
            if ($request->hasFile('page_header_image')) {
                $fileData = $imageService->handleFileUpload('page_images', $request->file('page_header_image'), $page->page_header_image, 'public');
                $requestData['page_header_image'] = $fileData;
            } else {
                if (isset($request->isImgDel) && $request->isImgDel == 1) {
                    $fileData = $imageService->handleFileUpload('page_images', '', $page->page_header_image, 'public');
                }
                $requestData['page_header_image'] = $fileData;
            }
            DB::transaction(function () use ($requestData, $page) {
                Page::createOrUpdatePage($requestData, $page->page_id);
            }, 1);
            return redirect()->route('admin.pages.index')->with('success', 'Page is updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied for this action.',
            ], 200);
        }
        try {
            DB::transaction(function () use ($id) {
                Page::destroy($id);
            }, 1);
            return response()->json([
                'success' => true,
                'message' => 'Page is deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 200);
        }
    }

    public function multipleDelete(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied for this action.',
            ], 200);
        }
        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                Page::destroy($postData['ids']);
            }, 1);
            //Page::whereIn('page_id', $postData['ids'])->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pages are deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 200);
        }
    }

    public function multipleChangeStatus(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied for this action.',
            ], 200);
        }
        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                $status = ($postData['status'] == "active") ? 1 : 0;
                //Find and update multiple users status
                Page::whereIn('page_id', $postData['ids'])->update(['status' => $status]);
            }, 1);
            return response()->json([
                'success' => true,
                'message' => "Status is updated successfully.",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 200);
        }
    }

    public function changeStatus(Request $request)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied for this action.',
            ], 200);
        }

        $postData = $request->all();
        try {
            DB::transaction(function () use ($postData) {
                $pageObj = Page::findOrFail($postData['id']);
                $status = ($pageObj->status == 1) ? 0 : 1;
                //Update page status
                $pageObj->update(['status' => $status]);
            }, 1);
            return response()->json([
                'success' => true,
                'message' => 'Status is updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 200);
        }
    }
}
