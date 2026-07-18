<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function show_food_items()
    {
        $food_items = FoodItem::with('category')->get();
        return view('admin.food-item', compact('food_items'));
    }

    public function update_status(Request $request, FoodItem $food_item)
    {
        $food_item->update([
            'is_available' => $request->status,
        ]);

        return back();
    }

    public function destroy(Request $request)
    {
        $food_item = FoodItem::find($request->id);
        if ($food_item->delete()) {
            return redirect('/admin/foods');
        }
    }
}
