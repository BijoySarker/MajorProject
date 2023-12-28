@extends('layout')

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

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" name="price" class="form-control" placeholder="Price" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <input type="text" name="category" class="form-control" placeholder="Category Name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" name="brand" class="form-control" placeholder="Brand Name" required>
                    </div>
                </div>

                <div class="col-md-12">
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

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection