<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderImageRequest;
use App\Models\Admin\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use Illuminate\Support\Facades\Gate;

class SliderImageController extends Controller
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
            $sliderImageList = SliderImage::select(
                '*',
            );
            if (!empty($request->get('startDate')) && !empty($request->get('endDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $sliderImageList->whereBetween(DB::RAW('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$startDate, $endDate]);
            }
            if (!empty($request->get('startDate')) && empty($request->get('endDate'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $sliderImageList->whereDate('created_at', '>=', $startDate);
            }
            if (!empty($request->get('endDate')) && empty($request->get('startDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $sliderImageList->whereDate('created_at', '<=', $endDate);
            }
            $sliderImageList->whereNull('deleted_at');
            $sliderImageList = $sliderImageList;
            return Datatables::of($sliderImageList)
                ->editColumn('description', function ($sliderImageList) {
                    if (isset($sliderImageList->description) && $sliderImageList->description != "") {
                        return html_entity_decode(strip_tags($sliderImageList->description));
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($sliderImageList) {
                    //return $sliderImageList->created_at->diffForHumans();
                    return $sliderImageList->created_at->format('d-m-Y');
                })
                ->filterColumn('created_at', function ($query, $keyword) use ($sliderImageList) {
                    $query->whereRaw('DATE_FORMAT(created_at, "%d-%m-%Y") LIKE ?', ["%{$keyword}%"]);
                })
                ->toJson();
        }
        return view('admin.slider_image.slider_image_list');
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
        return view('admin.slider_image.slider_image_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderImageRequest $request, ImageService $imageService)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $fileData = "";
            $requestData = $request->validated();
            $requestData['created_by'] = Auth::guard('admin')->id();
            if ($request->hasFile('slider_image')) {
                $fileData = $imageService->handleFileUpload('slider_images', $request->file('slider_image'), '', 'public');
                $requestData['slider_image'] = $fileData;
            }
            DB::transaction(function () use ($requestData) {
                SliderImage::createOrUpdateSliderImage($requestData, '');
            }, 1);
            return redirect()->route('admin.slider-images.index')->with('success', 'Slider image is added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SliderImage  $slider_image
     * @return \Illuminate\Http\Response
     */
    public function show(SliderImage $slider_image)
    {
        return view('admin.slider_image.slider_image_add', compact('slider_image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SliderImage  $slider_image
     * @return \Illuminate\Http\Response
     */
    public function edit(SliderImage $slider_image, ImageService $imageService)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        return view('admin.slider_image.slider_image_add', compact('slider_image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SliderImage  $slider_image
     * @return \Illuminate\Http\Response
     */
    public function update(SliderImageRequest $request, SliderImage $slider_image, ImageService $imageService)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
        try {
            $fileData = $slider_image->slider_image;
            $requestData = $request->validated();
            $requestData['updated_by'] = Auth::guard('admin')->id();
            if ($request->hasFile('slider_image')) {
                $fileData = $imageService->handleFileUpload('slider_images', $request->file('slider_image'), $slider_image->slider_image, 'public');
                $requestData['slider_image'] = $fileData;
            } else {
                if (isset($request->isImgDel) &&  $request->isImgDel == 1) {
                    $fileData = $imageService->handleFileUpload('slider_images', '', $slider_image->slider_image, 'public');
                }
                $requestData['slider_image'] = $fileData;
            }

            DB::transaction(function () use ($requestData, $slider_image) {
                SliderImage::createOrUpdateSliderImage($requestData, $slider_image->slider_id);
            }, 1);
            return redirect()->route('admin.slider-images.index')->with('success', 'Slider image is updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SliderImage  $slider_image
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
                SliderImage::destroy($id);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => 'Slider image is deleted successfully.'
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
                SliderImage::destroy($postData['ids']);
            }, 1);
            //SliderImage::whereIn('slider_id', $postData['ids'])->delete();
            return response()->json([
                'success' => true,
                'message'   => 'Slider images are deleted successfully.'
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
                SliderImage::whereIn('slider_id', $postData['ids'])->update(['status' => $status]);
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
                $sliderImageObj = SliderImage::findOrFail($postData['id']);
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
}
