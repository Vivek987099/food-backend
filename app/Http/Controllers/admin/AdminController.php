<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function addCategory(Request $req)
    {
        $validateReq = $req->validate([
            'name' => 'required',
            'image' => 'nullable|image'
        ]);
        if ($req->hasFile('image')) {
            $validateReq['image'] = $req->file('image')->store('image', 'public');
        }

        $cat = Category::create($validateReq);

        $cat->slug = Str::slug($cat->name) . '-' . $cat->id;
        $cat->save();
        return redirect('/admin/category');
    }

    public function show_categories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

   
    

    public function addFoodItem()
    {
        $categories = Category::all();
        return view('admin.add-food-item', compact('categories'));
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
}
