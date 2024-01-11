<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryChild;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $childCategories = CategoryChild::all();

        $brands = Brand::all();

        return view('product.create', ['childCategories' => $childCategories, 'brands' => $brands]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'category' => 'required|exists:category_children,name',
            'brand' => 'required',
            'description' => 'required',
            'product_warranty' => 'required',
            'product_quantity' => 'required|integer',
            'product_specifications' => 'required|string',
            'product_image' => 'sometimes|required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
            'product_gallery.*' => 'sometimes|required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        $productImage = null;
        if ($request->hasFile('product_image')) {
            $productImage = $this->uploadFile($request->file('product_image'), 'product_images');
        }

        $productGallery = [];

        if ($request->hasFile('product_gallery')) {
            foreach ($request->file('product_gallery') as $galleryImage) {
                $productGallery[] = $this->uploadFile($galleryImage, 'product_gallery');
            }
        }

        Product::create([
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
            'brand' => $request->input('brand'),
            'description' => $request->input('description'),
            'product_warranty' => $request->input('product_warranty'),
            'product_quantity' => $request->input('product_quantity'),
            'product_specifications' => $request->input('product_specifications'),
            'product_image' => $productImage,
            'product_gallery' => $productGallery,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    private function uploadFile($file, $folder)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('products/' . $folder, $fileName, 'public');
        return '/storage/' . $path;
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $childCategories = CategoryChild::all();
        $brands = Brand::all();

        return view('product.edit', compact('product', 'childCategories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
    $request->validate([
        'product_name' => 'sometimes|required',
        'price' => 'sometimes|required',
        'category' => 'sometimes|required',
        'brand' => 'sometimes|required',
        'description' => 'sometimes|required',
        'product_warranty' => 'sometimes|required',
        'image' => 'sometimes|image|mimes:webp,jpeg,png,jpg,gif|max:2048', // Updated the image validation
        'product_gallery.*' => 'sometimes|image|mimes:webp,jpeg,png,jpg,gif|max:2048', // Updated the product gallery validation
    ]);

    // Update other fields
    $product->update($request->except('image', 'product_gallery', 'removed_images'));

    // Update product image if provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists (optional)
        if ($product->product_image) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->product_image));
        }

        // Upload the new image
        $fileName = time() . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('products/product_images', $fileName, 'public');

        // Update the 'product_image' field with the new path
        $product->update(['product_image' => '/storage/' . $path]);
    }

    // Update product gallery if provided
    if ($request->hasFile('product_gallery')) {
        $galleryImages = [];
        foreach ($request->file('product_gallery') as $galleryImage) {
            $galleryImagePath = $galleryImage->store('products/product_gallery', 'public');
            $galleryImages[] = '/storage/' . $galleryImagePath;
        }
        $product->update(['product_gallery' => $galleryImages]);
    }

    // Remove selected gallery images
    $removedImages = $request->input('removed_images');
    if ($removedImages) {
        $removedImagesArray = explode(',', rtrim($removedImages, ','));
        foreach ($removedImagesArray as $removedImage) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $removedImage));
        }
    }

    return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('product_name', 'LIKE', "%$query%")->get();

        return view('quotation.product_search_results', compact('products'));
    }
}