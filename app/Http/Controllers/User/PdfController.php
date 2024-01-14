<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Incomes\Investment;
use App\Models\Estate;
use Illuminate\Http\Request;
use PDF;
use PDFF;


class PdfController extends Controller
{
    public function generatePDF($subdomain)
    {
         try{
        $data = [
            'title' => 'Welcome to Nicesnippets.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf', $data);
        return $pdf->stream('document.pdf');


//        old pdf

        $pdf = PDF::loadView('pdf', $data);

        $pdf->setPaper('L');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.1,"Multiply");

        $canvas->set_opacity(.1);

        $canvas->page_text($width/5, $height/2, '', null,
            55, array(0,0,0),2,2,-30);



            return $pdf->stream();
        }catch(\Exception $e){
           return redirect()->back()->with('error' , 'معلومات العقار غير مكتملة');
       }

    }

    public function report_page($subdomain){
        $types = Investment::where('type', 'main')->pluck('estate_id');
        $estates = Estate::whereIn('id',$types)->get();
        return view('frontend.incomes.reports', compact('estates'));
    }
    public function report_form($subdomain,Request $request){
       try{
            $id = $request->id;
        $estate = Estate::find($id);
        $option = Investment::where('estate_id' , $id)->get();

        $data = [
            'title' => 'Estate Data',
            'date' => date('m/d/Y'),
            'option' => $option,
            'estate' => $estate,
        ];

        $pdf = PDF::loadView('pdf', $data);
        $name = $estate->name_arabic ?: 'العقار';

        return $pdf->download(''.$name.'.pdf');
       }catch(\Exception $e){
           return redirect()->back()->with('error' , 'معلومات العقار غير مكتملة');
       }
    }

    public function generatePDF_pro($subdomain,$id)
    {
         try{
        $estate = Estate::find($id);
        $option = Investment::where('estate_id' , $id)->get();

        $data = [
            'title' => 'Welcome',
            'date' => date('m/d/Y'),
            'option' => $option,
            'estate' => $estate,
        ];

        $pdf = PDF::loadView('pdf', $data);

        return $pdf->download('العقار.pdf');


//        old pdf

        $pdf = PDF::loadView('pdf', $data);

        $pdf->setPaper('L');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.1,"Multiply");

        $canvas->set_opacity(.1);

        $canvas->page_text($width/5, $height/2, '', null,
            55, array(0,0,0),2,2,-30);

             return $pdf->stream();
        }catch(\Exception $e){
           return redirect()->back()->with('error' , 'معلومات العقار غير مكتملة');
       }

    }

    public function show_pdf($subdomain,$id)
    {
        $estate = Estate::find($id);
        $option = Investment::where('estate_id' , $id)->get();

        $data = [
            'title' => 'Welcome',
            'date' => date('m/d/Y'),
            'option' => $option,
            'estate' => $estate,
        ];

        return view('pdf' , compact('estate' , 'option'));


//        old pdf

        $pdf = PDF::loadView('pdf', $data);

        $pdf->setPaper('L');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.1,"Multiply");

        $canvas->set_opacity(.1);

        $canvas->page_text($width/5, $height/2, '', null,
            55, array(0,0,0),2,2,-30);

        return $pdf->stream();
    }
}
