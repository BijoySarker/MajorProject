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

        <form action="{{ route('product.update',$product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_name">Name:</label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control" placeholder="Change Product Name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control" placeholder="Change Price">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <input type="text" name="category" value="{{ old('category', $product->category) }}" class="form-control" placeholder="Change Category Name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control" placeholder="Change Brand Name">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" style="height:150px" name="description" placeholder="Change Description">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_warranty">Product Warranty:</label>
                        <input type="text" name="product_warranty" value="{{ old('product_warranty', $product->product_warranty) }}" class="form-control" placeholder="Change Warranty">
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection