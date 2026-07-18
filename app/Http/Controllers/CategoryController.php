<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\fileExists;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::paginate(10);
        return response()->json([
            'status'=>true,
            'categories'=> $category
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = null;
        $validate_req = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'image'=>'nullable|image'
            ]
        );
        if ($validate_req->fails()) {
            return $this->sendError(422, 'Validation Error', $validate_req->errors()->all());
        }
        if($request->hasFile('image')){
            $file = $request->file('image')->store('image','public');
        }
        $savesCat = Category::create([
            'name' => $request->name,
            'image'=> $file
        ]);
        if($savesCat){
            return $this->sendResponse('Category created successfully', $savesCat, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if($category){
            return response()->json([
                'status'=>true,
                'item'=>$category
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'No item found'
            ]);
        }
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
        $category = Category::find($id);
        if($category){
            if($category->image){
                $file = public_path('/storage/').$category->image;
                if(fileExists($file)){
                    unlink($file);
                }
            }
            if($category ->delete()){
                return response()->json([
                    'status'=>true,
                    'message'=>'Category deleted successfully'
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Category not found'
            ]);
        }
    }
}
