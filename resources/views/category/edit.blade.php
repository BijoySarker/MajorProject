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

        <form action="{{ route('categories.update', $childCategory->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="image">Image:</label>
                        <div id="imageContainer" class="mb-3">
                            @if ($childCategory->image)
                                <img src="{{ asset($childCategory->image) }}" alt="Image" class="img-thumbnail">
                                <button type="button" class="btn btn-danger mt-2" id="removeImageButton">Remove Image</button>
                                <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                            @endif
                        </div>
                        <div id="newImageSection" style="display:none;">
                            <input type="file" name="image" id="newImage" class="form-control">
                        </div>
                    </div>
                </div>
            
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removeImageButton = document.getElementById('removeImageButton');
            var imageContainer = document.getElementById('imageContainer');
            var newImageSection = document.getElementById('newImageSection');
            var removeImageInput = document.getElementById('removeImageInput');
            var imageInput = document.getElementById('newImage');
    
            // Show/hide elements based on whether an image exists
            function toggleImageElements() {
                if (imageContainer.querySelector('img')) {
                    imageContainer.style.display = 'block';
                    newImageSection.style.display = 'none';
                } else {
                    imageContainer.style.display = 'none';
                    newImageSection.style.display = 'block';
                }
            }
    
            // Initial toggle
            toggleImageElements();
    
            removeImageButton.addEventListener('click', function () {
                // Set the value of the remove_image input to 1
                removeImageInput.value = '1';
    
                // Clear the existing image preview
                imageContainer.innerHTML = '';
    
                // Toggle image elements visibility
                toggleImageElements();
            });
    
            // Update image preview on new image selection
            imageInput.addEventListener('change', function () {
                // Clear the existing image preview
                imageContainer.innerHTML = '';
    
                // Create a new image element
                var newImage = document.createElement('img');
                newImage.src = URL.createObjectURL(this.files[0]);
                newImage.alt = 'New Image';
                newImage.classList.add('img-thumbnail');
    
                // Append the new image to the container
                imageContainer.appendChild(newImage);
    
                // Toggle image elements visibility
                toggleImageElements();
            });
        });
    </script>
@endsection