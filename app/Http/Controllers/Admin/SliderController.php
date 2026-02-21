<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Models\Slider;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order', 'asc')->get();
        return view('admin.layouts.pages.home.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.layouts.pages.home.slider.create');
    }

    public function store(SliderStoreRequest $request)
    {
        try {

            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/sliders'), $imageName);
            }

            Slider::create([
                'title'      => $request->title,
                'sub_title'  => $request->sub_title,
                'image'      => $imageName,
                'sort_order' => $request->sort_order ?? 0,
                'status'     => $request->status,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Slider created successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while creating slider.'
            ], 500);
        }
    }


    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.layouts.pages.home.slider.edit', compact('slider'));
    }


    public function update(SliderUpdateRequest $request, $id)
    {
        $slider = Slider::findOrFail($id);

        try {
            if ($request->hasFile('image')) {
                if ($slider->image && file_exists(public_path('uploads/sliders/' . $slider->image))) {
                    unlink(public_path('uploads/sliders/' . $slider->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/sliders'), $imageName);
                $slider->image = $imageName;
            }

            $slider->title      = $request->title;
            $slider->sub_title  = $request->sub_title;
            $slider->sort_order = $request->sort_order ?? 0;
            $slider->status     = $request->status;

            $slider->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Slider updated successfully!',
                'actionUrl' => route('admin.home.slider.index'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while updating slider.'
            ], 500);
        }
    }



    public function destroy($id)
    {
        $slider =  Slider::findOrFail($id);
        $slider->delete();
        return redirect()->back()->with('success', 'Slider deleted successfully');
    }
}
