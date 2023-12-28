@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Edit Product</h2>
                <a class="btn btn-primary" href="{{ route('categories.index') }}">Back</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <strong>Error!</strong> <br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update',$childCategory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mt-3">
                <div class="form-group">
                    <label for="category_id">Parent Category:</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Select Existing Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $childCategory->category && $childCategory->category->id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        <option value="new">Add New Parent Category</option>
                    </select>
                </div>
        
                <div class="form-group" id="newCategoryInput" style="display: none;">
                    <label for="new_category_name">New Parent Category Name:</label>
                    <input type="text" class="form-control" name="new_category_name">
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Category Name: </label>
                        <input type="text" name="name" value="{{ old('price', $childCategory->name) }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">status:</label>
                        <input type="text" name="status" value="{{ old('category', $childCategory->status) }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="icon">Icon:</label>
                
                        <!-- Display current image -->
                        @if($childCategory->image)
                            <img src="{{ asset('storage/' . $childCategory->image) }}" alt="Current Image" style="max-width: 100%;">
                        @endif
                
                        <br>
                
                        <!-- Checkbox to delete the current image -->
                        <input type="checkbox" id="deleteImage" name="deleteImage">
                        <label for="deleteImage">Delete current image</label>
                
                        <!-- File input for uploading a new image -->
                        <input type="file" name="newIcon" id="newIcon" style="display: none;">
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        
        // Add this script to toggle the visibility of the new_category_name input field
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const newCategoryInput = document.getElementById('newCategoryInput');
    
            categorySelect.addEventListener('change', function () {
                newCategoryInput.style.display = categorySelect.value === 'new' ? 'block' : 'none';
            });
        });

        
        // Add event listener to the delete checkbox
    document.getElementById('deleteImage').addEventListener('change', function () {
        // Get the file input element
        var newIconInput = document.getElementById('newIcon');

        // Toggle the visibility of the file input based on the delete checkbox state
        newIconInput.style.display = this.checked ? 'block' : 'none';
    });
    </script>
@endsection