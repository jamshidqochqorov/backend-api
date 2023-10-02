<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::with('category')->get());
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'body'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required'
        ]);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product = new Product();
            $product->name = $request->name;
            $product->body = $request->body;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->image = $imageName;
            $product->save();
            return response()->json([
                'message'=>'Product is successfully created',
                'product'=>new ProductResource($product)
            ]);
        }

    }

    public function show($id)
    {
        $product  = Product::with('category')->find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product) ;
    }


    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        $this->validate($request,[
            'name'=>'required',Rule::unique('products')->ignore($id),
            'body'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'price'=>'required'
        ]);
        if($request->hasFile('image')){
            unlink('images/products/'.$product->image);
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product = Product::find($id);
            $product->name = $request->name;
            $product->body = $request->body;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->image = $imageName;
            $product->save();
            return response()->json(['data'=>[
                'message'=>'Product is successfully updated',
                'product'=>new ProductResource($product)
            ]]);
        }
        else{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->body = $request->body;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->save();
            return response()->json(['data'=>[
                'message'=>'Product is successfully updated',
                'product'=>new ProductResource($product)
            ]]);
        }


    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product is successfully deleted']);
    }
}
