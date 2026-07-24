<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function destroy(Request $request)
    {
        $category = Category::find($request->id);
        if ($category->delete()) {
            redirect('/admin/category');
        }
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('admin.category.edit', compact('category'));
    }

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
        return view('admin.category.categories', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $file_path = $category->image;
        if ($request->hasFile('image')) {
            if ($category->image !== null) {
                $path = public_path('storage/' . $category->image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $file_path = $request->file('image')->store('image', 'public');
        }
        $category->update([
            'name' => $request->name,
            'image' => $file_path
        ]);
        return redirect('admin/category')->with('success', 'Food item updated successfully');
    }
}
