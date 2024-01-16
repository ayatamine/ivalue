<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        try {

            $setting = Option::select('phone','title','title_en','address','mobile','whats','about','email',
            'website','commercial_number','commercial_date','license_number','license_date','image_commercial','image_license')
            ->find(1);
            return view('frontend.settings.edit',compact('setting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function reportsSettings()
    {
        try {
            $setting = Option::select('stamp','logo','header','footer','background','cover',
            'offer_price','price_delay','currency','work_area','work_delay','payment_partitions',
            'report_standards','report_desc','report_kind')->find(1);
            return view('frontend.settings.reports',compact('setting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function ratingSettings()
    {
        try {
            $setting = Option::select('step_percentage','work_hour_percentage')->find(1);
            $step_percentage =json_decode($setting->step_percentage,true);
            $work_hour_percentage =json_decode($setting->work_hour_percentage,true);
            return view('frontend.settings.rating',compact('step_percentage','work_hour_percentage','setting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }

    public function update_settings($subdomain,Request $request)
    {
        try {
            $setting = Option::find(1);

            $setting->title = $request->name_arabic;
            $setting->title_en = $request->name_english;
            $setting->address = $request->address;
            $setting->phone = $request->phone;
            $setting->mobile = $request->mobile;
            $setting->whats = $request->whatsapp;
            $setting->about = $request->about;
            $setting->email = $request->email;
            $setting->website = $request->website;
            $setting->commercial_number = $request->commercial_number;
            $setting->commercial_date = $request->commercial_date;
            $setting->license_number = $request->license_number;
            $setting->license_date = $request->license_date;

            if ($request->hasFile('image_commercial')) {
                $filename = time() . '-' . $request->image_commercial->getClientOriginalName();
                $request->image_commercial->move(public_path('pictures/settings'), $filename);
                $setting->image_commercial = $filename;
            }

            if ($request->hasFile('image_license')) {
                $filename = time() . '-' . $request->image_license->getClientOriginalName();
                $request->image_license->move(public_path('pictures/settings'), $filename);
                $setting->image_license = $filename;
            }


            $setting->save();
            return redirect()->back()->with('done', 'تم التعديل بنجاح ....');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function update_reports_settings($subdomain,Request $request)
    {
        try {
            $setting = Option::find(1);

            if ($request->hasFile('stamp')) {
                $filename = time() . '-' . $request->stamp->getClientOriginalName();
                $request->stamp->move(public_path('pictures/settings'), $filename);
                $setting->stamp = $filename;
            }

            if ($request->hasFile('logo')) {
                $filename = time() . '-' . $request->logo->getClientOriginalName();
                $request->logo->move(public_path('pictures/settings'), $filename);
                $setting->logo = $filename;
            }

            if ($request->hasFile('header')) {
                $filename = time() . '-' . $request->header->getClientOriginalName();
                $request->header->move(public_path('pictures/settings'), $filename);
                $setting->header = $filename;
            }

            if ($request->hasFile('footer')) {
                $filename = time() . '-' . $request->footer->getClientOriginalName();
                $request->footer->move(public_path('pictures/settings'), $filename);
                $setting->footer = $filename;
            }

            if ($request->hasFile('background')) {
                $filename = time() . '-' . $request->background->getClientOriginalName();
                $request->background->move(public_path('pictures/settings'), $filename);
                $setting->background = $filename;
            }

            if ($request->hasFile('cover')) {
                $filename = time() . '-' . $request->cover->getClientOriginalName();
                $request->cover->move(public_path('pictures/settings'), $filename);
                $setting->cover = $filename;
            }

            $setting->save();
            return redirect()->back()->with('done', 'تم التعديل بنجاح ....');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function update_rating_settings($subdomain,Request $request)
    {
        try {
            $setting = Option::find(1);

            if($request->step_percentage)
            {
                $setting->step_percentage = json_encode($request->step_percentage);
            }
            if($request->work_hour_percentage)
            {
                $setting->work_hour_percentage = json_encode($request->work_hour_percentage);
            }

            $setting->save();
            return redirect()->back()->with('done', 'تم التعديل بنجاح ....');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
