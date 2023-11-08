<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use UploadTrait;
    public function index()
    {
        try {
            $sliders = Slider::orderBy('id', 'desc')->get();
            return view('backend.sliders.index', compact('sliders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function create()
    {
        try {
            return view('backend.sliders.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Try Again !!');
        }
    }
    public function store(SliderRequest $request)
    {
        try {
            $slider = new Slider();
            $slider->title = $request->title;
            $slider->subtitle = $request->subtitle;
            $slider->link = $request->link;
            if ($request->active) {
                $slider->active = 1;
            } else {
                $slider->active = 0;
            }
            $slider->save();
            if ($request->hasFile('image')) {
                $this->saveimage($request->image, 'pictures/sliders', $slider->id , Slider::class, 'main');
            }
            return redirect()->route('sliders.index')->with('done', 'تم الاضافة بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        if (isset($slider)) {
            return view('backend.sliders.edit', compact('slider'));
        } else {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function update(SliderRequest $request, $id)
    {
        try {
            $slider = Slider::find($id);
            $slider->title = $request->title;
            $slider->subtitle = $request->subtitle;
            $slider->link = $request->link;
            if ($request->active) {
                $slider->active = 1;
            } else {
                $slider->active = 0;
            }
            $slider->save();
            if ($request->hasFile('image')) {
                $this->editimage($request->image, 'pictures/sliders', $slider->id , Slider::class, 'main');
            }
            return redirect()->route('sliders.index')->with('done', 'تم التعديل بنجاح ....');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::find($id);
            $this->deleteimages($slider->id , 'pictures/sliders/' , Slider::class);
            $slider->delete();
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }

    public function delete_sliders()
    {
        try {
            $sliders = Slider::all();
            if (count($sliders) > 0) {
                foreach ($sliders as $slider) {
                    $this->deleteimages($slider->id , 'pictures/sliders/' , Slider::class);
                    $slider->delete();
                }
                return response()->json([
                    'success' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'NO Record TO DELETE'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ !!');
        }
    }
}
