@extends('layout')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .product-container {
            margin-top: 20px;
        }

        .product-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .product-details {
            margin-top: 20px;
        }
    </style>

    <div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center bg-light p-3">
                <h2 class="mb-0">Product Details</h2>
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="form-group">
                <strong>Product Name:</strong>
                {{ $product->product_name }}
            </div>
        </div>

        <div class="col-md-8 mt-3">
            <div class="form-group">
                <strong>Price:</strong>
                &#2547;{{ number_format($product->price, 2) }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <div class="form-group">
                <strong>Category:</strong>
                {{ $product->category }}
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <div class="form-group">
                <strong>Brand:</strong>
                {{ App\Models\Brand::find($product->brand)->name }}
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $product->description }}
            </div>
        </div>
        
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <strong>Warranty:</strong>
                {{ $product->product_warranty }}
            </div>
        </div>
    </div>
</div>
@endsection