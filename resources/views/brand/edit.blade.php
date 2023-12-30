@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Edit Brand</h2>
                <a class="btn btn-primary" href="{{ route('brand.index') }}">Back</a>
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

        <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
            @csrf
            @method('PUT')
        
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_name">Brand Name:</label>
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="form-control" placeholder="Change Brand Name">
                    </div>
                </div>
        
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <div id="imageContainer" class="mb-3">
                            @if ($brand->image)
                                <img src="{{ asset($brand->image) }}" alt="Current Image" class="img-thumbnail">
                                <button type="button" class="btn btn-danger mt-2" id="removeImageButton">Remove Image</button>
                                <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                            @endif
                        </div>
                        <div id="newImageSection" style="display:none;">
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
        
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removeImageButton = document.getElementById('removeImageButton');
            var imageContainer = document.getElementById('imageContainer');
            var newImageSection = document.getElementById('newImageSection');
            var removeImageInput = document.getElementById('removeImageInput');
    
            removeImageButton.addEventListener('click', function () {
                imageContainer.style.display = 'none'; // Hide the entire container
                newImageSection.style.display = 'block';
                removeImageInput.value = '1'; // Set to 1 to indicate the removal of the image
            });
        });
    </script>
@endsection