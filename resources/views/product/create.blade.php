@extends('layout')
@section('title', 'Create New Product')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Add New Product</h2>
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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&#2547;</span>
                            </div>
                            <input type="text" name="price" class="form-control" placeholder="Price" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($childCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <select name="brand" class="form-control" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="product_quantity">Quantity:</label>
                        <input type="number" name="product_quantity" class="form-control" placeholder="Product Quantity" required>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="product_image">Product Image:</label>
                        <input type="file" name="product_image" class="form-control">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="product_gallery">Product Gallery:</label>
                        <input type="file" class="form-control" name="product_gallery[]" multiple accept="image/*">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="product_specifications">Specifications:</label>
                        <textarea class="form-control" style="height:150px" name="product_specifications" placeholder="Product Specifications" required></textarea>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Description" required></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_warranty">Warranty:</label>
                        <input type="text" name="product_warranty" class="form-control" placeholder="Warranty" required>
                    </div>
                </div>

                

                
                
                <div class="col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function limitFiles(input, limit) {
            var files = input.files;
            if (files.length > limit) {
                alert("Please select up to " + limit + " images/files.");
                input.value = "";
            }
        }
    </script>
@endsection