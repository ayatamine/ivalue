<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Option;

class OptionController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:option-edit', ['only' => ['edit','update']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = Option::find(1);
        if (isset($option)) {
            return view('backend.options.edit', compact('option'));
        } else {
            return redirect()->back()->with('error', 'ERROR TRY AGAIN!!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, $id)
    {
        try {
            $option = Option::find($id);
            $option->title = $request->title;
            $option->face = $request->face;
            $option->insta = $request->insta;
            $option->whats = $request->whats;
            $option->phone = $request->phone;
            $option->email = $request->email;
            $option->save();
            return redirect()->route('options.edit' , 1)->with('done', 'تم التعديل بنجاح...');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'خطأ يرجي المحاولة في وقت لاحق !!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
