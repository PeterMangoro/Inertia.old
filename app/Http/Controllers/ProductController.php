<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $products = Product::all();
        return Inertia::render('Shop/index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Shop/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $request->validate([
            'title'=>'required|string',
            'detail'=>'required|string',
            'image'=> 'required|image|mimes:png,jpg,jpeg,gif,svg|max:6144'  //3mb
        ]);
        if ($request->hasFile('image')){
            foreach($request->file('image') as $image)
            {
                $image_path = $request->file('image')->store('shop','public');  
                $data[] = $image_path;
            }
         
        }
        $product = new Product;
        $product->image=json_encode($data);
        $product->title=$request->title;
        $product->detail=$request->detail;
        $product->price=$request->price;
        $product->save();
      
        return back()->with('success','Product Updated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $product=Product::find($id);
        return Inertia::render('Shop/product-details',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        return Inertia::render('Shop/edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validate([
            'title'=>'required|string',
            'detail'=>'required|string',
            'image'=> 'required|image|mimes:png,jpg,jpeg,gif,svg|max:6144'  //3mb
        ]);
        if ($request->hasFile('image')){
            foreach($request->file('image') as $image)
            {
                $image_path = $request->file('image')->store('shop','public');  
                $data[] = $image_path;
            }
         
        }
       
        $product->image=json_encode($data);
        $product->title=$request->title;
        $product->detail=$request->detail;
        $product->price=$request->price;
        $product->update();
      
        return back()->with('success','Product Updated Successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Product deleted successfully');
    }
}
