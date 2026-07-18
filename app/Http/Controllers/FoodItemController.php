<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\FoodItemRequest;
use App\Models\FoodItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FoodItem::with('category');
        if ($request->filled('category')) {
            $category_id = $request->category;
            $query->where('category_id', $category_id);
        }
        $food_items = $query->paginate(10);
        if (count($food_items) > 0) {
            return response()->json([
                'status' => true,
                'food' => $food_items
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No items found'
            ]);
        }
    }

    public function search_food_item(Request $request)
    {
        $search_item = $request->query('search');
        $food_items = FoodItem::where(function ($query) use ($search_item) {
            $query->where('name', 'LIKE', '%' . $search_item . '%')->orWhere('description', 'LIKE', '%' . $search_item . '%');
        })->where('is_available', true)->get();
        return response()->json([
            'status' => true,
            'items' => $food_items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodItemRequest $request)
    {
        $validateData = $request->validated();
        if ($request->hasFile('image')) $validateData['image'] = $request->file('image')->store('image', 'public');


        $food_item = FoodItem::create($validateData);
        $food_item->slug = Str::slug($food_item->name) . '-' . $food_item->id;
        $food_item->save();
        if (!$food_item) {
            return response()->json([
                'status' => false,
                'message' => 'Food items creation failed',
            ], 500);
        }
        return response()->json([
            'status' => true,
            'message' => 'Food items created successfully',
            'data' => $food_item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $arr = explode('-', $slug);
        $id = end($arr);
        $item = FoodItem::with('category')->find($id);
        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item is not available'
            ]);
        }
        return response()->json([
            'status' => true,
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $food_item = FoodItem::find($id);
        if ($food_item) {
            if ($food_item->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Items deleted successfully'
                ], 200);
            };
        }
    }
}
