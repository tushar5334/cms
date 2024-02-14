<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class InquiryController extends Controller
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
            $inquiryList = Inquiry::select(
                '*'
            );
            if (!empty($request->get('startDate')) && !empty($request->get('endDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $inquiryList->whereBetween(DB::RAW('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$startDate, $endDate]);
            }
            if (!empty($request->get('startDate')) && empty($request->get('endDate'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->get('startDate'))->format('Y-m-d');
                $inquiryList->whereDate('created_at', '>=', $startDate);
            }
            if (!empty($request->get('endDate')) && empty($request->get('startDate'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->get('endDate'))->format('Y-m-d');
                $inquiryList->whereDate('created_at', '<=', $endDate);
            }
            $inquiryList->whereNull('deleted_at');
            $inquiryList = $inquiryList;
            return Datatables::of($inquiryList)
                ->editColumn('description', function ($inquiryList) {
                    if (isset($inquiryList->description) && $inquiryList->description != "") {
                        return html_entity_decode(strip_tags($inquiryList->description));
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($inquiryList) {
                    return $inquiryList->created_at->format('d-m-Y');
                })
                ->toJson();
        }
        return view('admin.reports.inquiry_list');
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inquiry $inquiry)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Inquiry $inquiry)
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            return redirect()->route('admin.get.dashboard')->with('error', 'Access denied for this page.');
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
                'message'   => 'Access denied for this action.'
            ], 200);
        }
        try {
            DB::transaction(function () use ($id) {
                Inquiry::destroy($id);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => 'Inquiry is deleted successfully.'
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
                Inquiry::destroy($postData['ids']);
            }, 1);
            return response()->json([
                'success' => true,
                'message'   => 'Inquiries are deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'   => 'Something went wrong.'
            ], 200);
        }
    }
}
