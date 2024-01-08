<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        $childCategories = CategoryChild::paginate(20);

        return view('category.create', compact('categories', 'childCategories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'nullable|string',
            'new_category_name' => 'nullable|string',
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
            return redirect()->back()->with('error', 'Please select or add a valid parent category.');
        }
    
        if ($request->hasFile('image')) {
            $fileName = time() . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('categories', $fileName, 'public');
            $categoryChild->image = '/storage/' . $path;
        } else {
            $categoryChild->image = null;
        }
    
        $categoryChild->save();
    
        return redirect()->route('categories.index')->with('success', 'Child Category created successfully.');
    }


    public function edit($id)
    {
        $childCategory = CategoryChild::findOrFail($id);
        $categories = Category::all();

        return view('category.edit', compact('childCategory', 'categories'));
    }


    public function update(Request $request, CategoryChild $childCategory)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'new_category_name' => 'nullable|string',
            'name' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive',
            'image' => 'sometimes|required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->input('remove_image')) {
            if ($childCategory->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $childCategory->image));
            }

            $childCategory->update(['image' => null]);
        }

        if ($request->hasFile('image')) {
            if ($childCategory->image) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $childCategory->image));
            }

            $fileName = time() . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('categories', $fileName, 'public');

            $childCategory->update(['image' => '/storage/' . $path]);
        }

        $childCategory->update([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

        public function destroy(CategoryChild $categoryChild)
    {
        $categoryChild->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    public function parentCategories()
    {
        $categories = Category::all();
        return view('category.parentCategories', compact('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
