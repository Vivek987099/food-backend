<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class FoodItemController extends Controller
{
    public function show_food_items()
    {
        $food_items = FoodItem::with('category')->get();
        return view('admin.food-item.food-item', compact('food_items'));
    }

    public function show($slug)
    {
        $categories = Category::all();
        $food_item = FoodItem::where('slug', $slug)->first();
        return view('admin.food-item.edit', compact('categories', 'food_item'));
    }

    public function addFoodItem()
    {
        $categories = Category::all();
        return view('admin.food-item.add-food-item', compact('categories'));
    }
    public function storeFoodItem(Request $request)
    {
        $validateReq = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'nullable|image',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $validateReq['image'] = $request->file('image')->store('image', 'public');
        }

        $food_item = FoodItem::create($validateReq);
        $food_item->slug = Str::slug($food_item->name) . '-' . $food_item->id;
        if ($food_item->save()) {
            return redirect('/admin/foods')->with('status', 'Items added successfully');
        }
    }

    public function update_status(Request $request, FoodItem $food_item)
    {
        $food_item->update([
            'is_available' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $food_item = FoodItem::find($id);
        $file_path = $food_item->image;
        if ($request->hasFile('image')) {
            if ($food_item->image) {
                if (file_exists($food_item->image)) {
                    unlink($food_item->image);
                }
            }
            $file_path = $request->file('image')->store('image', 'public');
        }
        $food_item->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $file_path
        ]);
        return redirect('admin/foods')->with('success', 'Food item updated successfully');
    }

    public function destroy(Request $request)
    {
        $food_item = FoodItem::find($request->id);
        if ($food_item->delete()) {
            return redirect('/admin/foods');
        }
    }
}
