<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Export;
use App\Models\Import;
use Illuminate\Http\Request;

use App\Imports\ImportsImport;
use App\Imports\ExportsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $imports = Import::all();
            return view('backend.excels.index', compact('imports'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }

    }
    public function exports()
    {
        try{
            $imports = Export::all();
            return view('backend.excels.exports', compact('imports'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }

    }

    public function import()
    {
        try{
            $imports = Import::all();
            foreach($imports as $import){
                $import->delete();
            }
            Excel::import(new ImportsImport,request()->file('file'));
            return back()->with('done', 'تم اضافة ملف الايرادات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }

    }
    public function export()
    {
        try{
            $imports = Export::all();
            foreach($imports as $import){
                $import->delete();
            }
            Excel::import(new ExportsImport,request()->file('file'));
            return back()->with('done', 'تم اضافة ملف المصاريف بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
