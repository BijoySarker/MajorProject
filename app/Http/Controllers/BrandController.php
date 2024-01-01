<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $brands = Brand::when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
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
            'image' => 'required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        $requestData = $request->all();

    if ($request->hasFile('image')) {
        $fileName = time() . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('images', $fileName, 'public');
        $requestData["image"] = '/storage/' . $path;
    } else {
        $requestData["image"] = null;
    }

    Brand::create($requestData);

    return redirect()->route('brand.index')->with('success', 'Brand created successfully.');
}


    public function show(Brand $brand)
    {
        return view('brand.show',compact('brand'));
    }


    public function edit(Brand $brand)
    {
        return view('brand.edit',compact('brand'));
    }


    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'image' => 'sometimes|required|image|mimes:webp,jpeg,png,jpg,gif|max:2048', 
        ]);

        $brand->update(['name' => $request->input('name')]);

        // Check if a new image is being uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists (optional)
            if ($brand->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $brand->image));
            }

            // Upload the new image
            $fileName = time() . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('images', $fileName, 'public');

            // Update the 'image' field with the new path
            $brand->update(['image' => '/storage/' . $path]);
        }

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully');
    }

    
    public function destroy(Brand $brand)
    {
        $brand->delete();
  
        return redirect()->route('brand.index')->with('success','Brand deleted successfully');
    }
}
