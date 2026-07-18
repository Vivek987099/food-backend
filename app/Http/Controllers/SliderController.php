<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::where('status', true)->get();

        if (count($slider)) {
            return response()->json(
                [
                    'status' => true,
                    'sliders' => $slider
                ]
            );
        }
    }
}
