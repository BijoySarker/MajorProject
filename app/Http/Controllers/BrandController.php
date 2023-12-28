<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $brands = Brand::when($query, function ($q) use ($query) {
            $q->where('product_name', 'like', '%' . $query . '%');
        })->latest()->paginate(20);

        return view('brand.index', compact('brands'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('brand.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
        ]);
  
        Brand::create($request->all());
   
        return redirect()->route('brand.index')->with('success','Product created successfully.');
    }


    public function show(Brand $brand)
    {
        // $product = Product::where('id', $id)->get();
        // dd($product);
        return view('brand.show',compact('brand'));
    }


    public function edit(Brand $brand)
    {
        return view('brand.edit',compact('brand'));
    }


    public function update(Request $request,  Brand $brand)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'image' => 'sometimes|required',
        ]);
  
        $brand->update($request->all());
  
        return redirect()->route('brand.index')->with('success','Brand updated successfully');
    }

    
    public function destroy(Brand $brand)
    {
        $brand->delete();
  
        return redirect()->route('brand.index')->with('success','Brand deleted successfully');
    }
}
