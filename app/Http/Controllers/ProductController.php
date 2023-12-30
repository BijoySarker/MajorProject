<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $products = Product::when($query, function ($q) use ($query) {
            $q->where('product_name', 'like', '%' . $query . '%');
        })->latest()->paginate(20);

        return view('product.index', compact('products'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
{
    $brands = Brand::all(); // Assuming you have a Brand model

    return view('product.create', ['brands' => $brands]);
}


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'description' => 'required',
            'product_warranty' => 'required',
        ]);
  
        Product::create($request->all());
   
        return redirect()->route('products.index')->with('success','Product created successfully.');
    }


    public function show(Product $product)
    {
        // $product = Product::where('id', $id)->get();
        // dd($product);
        return view('product.show',compact('product'));
    }


    public function edit(Product $product)
    {
        return view('product.edit',compact('product'));
    }


    public function update(Request $request,  Product $product)
    {
        $request->validate([
            'product_name' => 'sometimes|required',
            'price' => 'sometimes|required',
            'category' => 'sometimes|required',
            'brand' => 'sometimes|required',
            'description' => 'sometimes|required',
            'product_warranty' => 'sometimes|required',
        ]);
  
        $product->update($request->all());
  
        return redirect()->route('products.index')->with('success','Product updated successfully');
    }

    
    public function destroy(Product $product)
    {
        $product->delete();
  
        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }
}