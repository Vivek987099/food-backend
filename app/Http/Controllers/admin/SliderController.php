<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.slider', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validate_request = Validator::make(
            $request->all(),
            [
                'image' => 'required'
            ]
        );
        $data = $validate_request->validated();
        $data['image'] = $request->file('image')->store('image', 'public');
        if (Slider::create($data)) {
            return redirect('/admin/sliders');
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update_status(Request $request, Slider $slider)
    {
        $slider->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $file_path = $slider->image;
        if ($request->hasFile('image')) {
            if ($slider->image !== null) {
                $path = public_path('storage/'.$slider->image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $file_path = $request->file('image')->store('image', 'public');
        }
        $slider->update([
            'title' => $request->name,
            'image' => $file_path
        ]);
        return redirect('admin/sliders')->with('success', 'Food item updated successfully');
    }

    public function destroy($id)
    {
        $slider =  Slider::find($id);
        if ($slider->image !== null) {
            $path = public_path('storage/'. $slider->image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $slider->delete();
        return redirect('admin/sliders')->with('success', 'Slider deleted successfully');
    }
}
