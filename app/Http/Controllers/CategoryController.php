<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryChild;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $childCategories = CategoryChild::with('category')->paginate(10);
        return view('category.index', compact('childCategories'));
    }


    public function create()
    {
        $categories = Category::all();
        $childCategories = CategoryChild::all();

        return view('category.create', compact('categories', 'childCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'nullable|string', // Change to string
            'new_category_name' => 'nullable|string', // Add validation for new category name
            'status' => 'required|in:active,inactive',
            'image' => 'image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $categoryChild = new CategoryChild([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        if ($request->input('category_id') === 'new') {
            $request->validate([
                'new_category_name' => 'required|string',
            ]);

            $newParentCategory = Category::create([
                'name' => $request->input('new_category_name'),
            ]);

            $categoryChild->category_id = $newParentCategory->id;
        } elseif ($request->filled('category_id')) {
            $categoryChild->category_id = $request->input('category_id');
        } else {
            // Handle the case when no category is selected or provided
            return redirect()->back()->with('error', 'Please select or add a valid parent category.');
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $categoryChild->image = $imagePath;
        }

        $categoryChild->save();

        return redirect()->route('categories.create')->with('success', 'Child Category created successfully.');
    }


    public function show($id)
    {
        $childCategory = CategoryChild::with('category')->findOrFail($id);

        return view('category.show', compact('childCategory'));
    }


    public function edit($id)
    {
        $childCategory = CategoryChild::findOrFail($id);
        $categories = Category::all();

        return view('category.edit', compact('childCategory', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'new_category_name' => 'nullable|string', // Add validation for new category name
            'name' => 'required|string',
            'status' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $childCategory = CategoryChild::findOrFail($id);

        // Update the fields
        $childCategory->category_id = $request->input('category_id');
        $childCategory->name = $request->input('name');
        $childCategory->status = $request->input('status');
        $childCategory->image = $request->input('icon');

        // Check if a new parent category name is provided
        if ($request->filled('new_category_name')) {
            // Update the parent category name
            $childCategory->category->update([
                'name' => $request->input('new_category_name'),
            ]);
        }

        // Save the changes
        $childCategory->save();

        return redirect()->route('categories.edit', $id)->with('success', 'Category updated successfully.');
    }


        public function destroy(CategoryChild $categoryChild)
    {
        $categoryChild->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
