<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-list', ['only' => ['index','show' , 'tree']]);
//        $this->middleware('permission:category-create', ['only' => ['create','store']]);
//        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:category-delete', ['only' => ['destroy' , 'delete_categories']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pages = Page::orderBy('id', 'desc')->get();
            return view('backend.pages.index',compact('pages'));
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
            return view('backend.pages.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        try {
            if($request->active){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            Page::create($request->all());
            return redirect()->route('pages.index')->with('done', 'Added Successfully ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
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
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (isset($page)) {
            return view('backend.pages.edit', compact('page'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        try {
            $page = Page::find($id);
            if($request->active || $id == 1){
                $request->request->add(['active' => 1]);
            }else{
                $request->request->add(['active' => 0]);
            }
            $page->update($request->all());
            return redirect()->route('pages.index')->with('done', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
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
        try {
            $page = Page::find($id);
            $page->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error Try Again !!'
            ],422);
        }

    }

    public function delete_pages()
    {
        try {
            $pages = Page::where('id' ,'!=' ,1)->get();
            if (count($pages) > 0) {
                foreach ($pages as $page) {
                    $page->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO EVENTS TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error Try Again !!'
            ],422);
        }
    }
}
