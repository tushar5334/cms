<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\InquiryRequest;
use App\Models\Front\Category;
use App\Models\Front\Inquiry;
use App\Models\Front\Page;
use App\Models\Front\Segment;
use App\Models\Front\SliderImage as FrontSliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slider_images = FrontSliderImage::Where('status', 1)->get();
        return view('front.page.home_page', compact('slider_images'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInnerPageContent(Request $request)
    {
        return view('front.page.inner_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductByCategory(Request $request)
    {
        $productByCategory = Category::with(['products'])->get()->toArray();
        echo '<pre>';
        print_r($productByCategory);
        echo '</pre>';
        return view('front.page.product_by_category_page', compact('productByCategory'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductBySegment(Request $request)
    {
        $productsBySegment = Segment::with(['products'])->get()->toArray();
        echo '<pre>';
        print_r($productsBySegment);
        echo '</pre>';

        return view('front.page.product_by_segment_page', compact('productsBySegment'));
    }

    public function getEnquiry()
    {
        return view('front.page.enquiry');
    }

    public function postEnquiry(InquiryRequest $request)
    {
        try {
            $requestData = $request->validated();
            DB::transaction(function () use ($requestData) {
                Inquiry::create($requestData);
            }, 1);
            return redirect()->route('front.get.enquiry')->with('success', 'Enquiry has been submitted successfully. We will contact you soon!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again!');
        }
    }
}
