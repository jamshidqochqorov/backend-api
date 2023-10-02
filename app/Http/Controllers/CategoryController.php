<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{


    public function index()
    {
        return CategoryResource::collection(Category::all());
    }



    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories'
        ]);
        $category = Category::create([
            'name'=>$request->name
        ]);
        return new CategoryResource($category);
    }


    public function show($id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(['data'=>[
                'message'=>"Category is not found"
            ]],404);
        } else{
            return new CategoryResource(Category::find($id));
        }

    }



    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(['data'=>[
                'message'=>"Category is not found"
            ]],404);
        }
        $this->validate($request,[
            'name'=>'required',['name'=>'unique:categories,name,'. $id]
        ]);
        $category->update($request->all());

        return new CategoryResource($category);

    }


    public function destroy($id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(['data'=>[
                'message'=>"Category is not found"
            ]],404);
        }
        $category->delete();
        return response()->json(['message'=>'Category is successfully deleted']);

    }
}
