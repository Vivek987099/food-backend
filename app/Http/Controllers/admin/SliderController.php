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
        return view('slider', compact('sliders'));
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

    public function update_status(Request $request, Slider $slider)
    {
        $slider->update([
            'status' => $request->status,
        ]);

        return back();
    }
}
