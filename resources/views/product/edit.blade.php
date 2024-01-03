@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Edit Product</h2>
                <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
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

        <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mt-3">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="product_name">Name:</label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" placeholder="Change Product Name">
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control" placeholder="Change Price">
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" class="form-control" required>
                            <option value="" disabled>Select Category</option>
                            @foreach ($childCategories as $category)
                                <option value="{{ $category->name }}" {{ $category->name == $product->category ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <select name="brand" class="form-control" required>
                            <option value="" disabled>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Change Description">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="product_warranty">Product Warranty:</label>
                        <input type="text" name="product_warranty" value="{{ old('product_warranty', $product->product_warranty) }}" class="form-control" placeholder="Change Warranty">
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="product_quantity">Quantity:</label>
                        <input type="text" name="product_quantity" value="{{ old('product_quantity', $product->product_quantity) }}" class="form-control" placeholder="Change Quantity">
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="product_specifications">Specifications:</label>
                        <textarea class="form-control" style="height:150px" name="product_specifications" placeholder="Change Specifications">{{ $product->product_specifications }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <div id="imageContainer" class="mb-3">
                            @if ($product->product_image)
                                <img src="{{ asset($product->product_image) }}" alt="Current Image" class="img-thumbnail">
                                <button type="button" class="btn btn-danger mt-2" id="removeImageButtonImage">Remove Image</button>
                                <input type="hidden" name="removed_images" id="removedImagesInput" value="">
                            @endif
                        </div>
                        <div id="newImageSection" style="display:none;">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_gallery">Gallery Images:</label>
                        <div id="imageContainerGallery" class="mb-3">
                            @if ($product->product_gallery)
                                @foreach ($product->product_gallery as $index => $galleryImage)
                                    <div>
                                        <img src="{{ asset($galleryImage) }}" alt="Gallery Image" class="img-thumbnail">
                                        <button type="button" class="btn btn-danger mt-2 remove-gallery-image" data-image-path="{{ $galleryImage }}">Remove Image</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="newImageSectionGallery" style="display:none;">
                            <input type="file" name="product_gallery[]" class="form-control" multiple>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removeImageButtonImage = document.getElementById('removeImageButtonImage');
            var imageContainer = document.getElementById('imageContainer');
            var newImageSection = document.getElementById('newImageSection');
            var removeImageInputImage = document.getElementById('removeImageInputImage');
    
            removeImageButtonImage.addEventListener('click', function () {
                imageContainer.style.display = 'none';
                newImageSection.style.display = 'block';
                removeImageInputImage.value = '1';
            });
    
            function removeImageGallery(imagePath, index) {
                // Uncomment the next line if you want to keep the confirmation prompt
                // if (!confirm('Are you sure you want to remove this gallery image?')) return;
    
                let removedImagesInput = document.getElementById('removed_images');
                if (!removedImagesInput) {
                    removedImagesInput = document.createElement('input');
                    removedImagesInput.type = 'hidden';
                    removedImagesInput.name = 'removed_images';
                    removedImagesInput.id = 'removed_images';
                    document.querySelector('form').appendChild(removedImagesInput);
                }
                removedImagesInput.value += imagePath + ',';
    
                let imageContainerGallery = document.querySelector(`[src="${imagePath}"]`).parentNode;
                imageContainerGallery.parentNode.removeChild(imageContainerGallery);
            }
    
            // Attach event listeners to all remove buttons in the gallery
            document.querySelectorAll('.remove-gallery-image').forEach(function(button, index) {
                button.addEventListener('click', function() {
                    // Get the image path from the data attribute
                    var imagePath = button.getAttribute('data-image-path');
                    // Call the removeImageGallery function
                    removeImageGallery(imagePath, index);
                });
            });
        });
    </script>
@endsection