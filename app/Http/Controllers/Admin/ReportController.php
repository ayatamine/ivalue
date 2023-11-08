<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Report;
use App\Traits\UploadTrait;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexo($slug)
    {
        try {
            $estate = Estate::where('slug' , $slug)->first();
            if(isset($estate)){
                $reports = Report::where('estate_id' , $estate->id)->orderBy('id' , 'desc')->get();
                return view('backend.reports.index', compact('estate','reports'));
            }else{
                return redirect()->back()->with('error', 'عقار غير مسجل !!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users = User::orderBy('id','desc')->get();
            return view('backend.reports.create',compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $report = new Report();
            $report->name = $request->name;
            $report->floor = $request->floor;
            $report->flat = $request->flat;
            $report->price = $request->price;
            $report->kind = $request->kind;
            if($request->kind == 1){
                $report->color = 'green';
            }elseif($request->kind == 2){
                $report->color = 'red';
            }elseif($request->kind == 3){
                $report->color = 'orange';
            }else{
                $report->color = 'black';
            }
            $report->date = $request->date;
            $report->user_id = $request->user_id;
            $report->estate_id = $request->estate_id;
            $report->save();

            $estate = Estate::find($report->estate_id);

            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/reports', $report->id , Report::class, 'main');
            }
            return redirect()->route('all_infos' , $estate->slug)->with('done', 'تم الاضافة بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $report = Report::where('slug' , $slug)->first();
            if(isset($report)){
                return view('backend.reports.show',compact('report'));
            }else{
                return redirect()->back()->with('error', 'تقرير غير مسجل !!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        try {
            $report = Report::where('slug' , $slug)->first();
            if(isset($report)){
                $users = User::orderBy('id','desc')->get();
                $estates = Estate::orderBy('id','desc')->get();
                return view('backend.reports.edit',compact('users','estates','report'));
            }else{
                return redirect()->back()->with('error', 'تقرير غير مسجل !!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $report = Report::find($id);
            $report->name = $request->name;
            $report->floor = $request->floor;
            $report->flat = $request->flat;
            $report->price = $request->price;
            $report->kind = $request->kind;
            if($request->kind == 1){
                $report->color = 'green';
            }elseif($request->kind == 2){
                $report->color = 'red';
            }elseif($request->kind == 3){
                $report->color = 'orange';
            }else{
                $report->color = 'black';
            }
            $report->date = $request->date;
            $report->user_id = $request->user_id;
            $report->estate_id = $request->estate_id;
            $report->save();

            $estate = Estate::find($report->estate_id);

            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/reports', $report->id , Report::class, 'main');
            }
            return redirect()->route('all_infos' , $estate->slug)->with('done', 'تم الاضافة بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
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
        try {
            $report = Report::find($id);
            $this->deleteimages($report->id , 'pictures/reports/' , Estate::class);
            $report->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function log($slug)
    {
        try{
            $report = Report::where('slug' , $slug)->first();
            $audits = $report->audits;
            return view('backend.reports.log', compact('audits' , 'report'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
