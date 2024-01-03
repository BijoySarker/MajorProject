@extends('layout')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .product-container {
        margin-top: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 8px;
    }

    .product-header {
        background-color: #343a40;
        color: #fff;
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    img {
        max-width: 100%;
        border-radius: 4px;
    }

    .btn-back {
        margin-top: 20px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center product-header">
                <h2 class="mb-0">Product Details</h2>
                <a class="btn btn-primary btn-back" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Product Information -->
        <div class="col-md-8">
            <div class="product-container">
                <div class="form-group">
                    <strong>Product Name:</strong>
                    {{ $product->product_name }}
                </div>

                <div class="form-group">
                    <strong>Price:</strong>
                    &#2547;{{ number_format($product->price, 2) }}
                </div>

                <div class="form-group">
                    <strong>Quantity:</strong>
                    {{ $product->product_quantity }}
                </div>

                <div class="form-group">
                    <strong>Category:</strong>
                    {{ $product->category }}
                </div>

                <div class="form-group">
                    <strong>Brand:</strong>
                    {{ App\Models\Brand::find($product->brand)->name }}
                </div>

                <div class="form-group">
                    <strong>Warranty:</strong>
                    {{ $product->product_warranty }}
                </div>
                
                <div class="form-group">
                    <strong>Product Specifications:</strong>
                    {{ $product->product_specifications }}
                </div>

                <div class="form-group">
                    <strong>Description:</strong>
                    {{ $product->description }}
                </div>

            </div>
        </div>

        <!-- Additional Product Details -->
        <div class="col-md-4">
            <div class="product-container">
                <div class="form-group">
                    <strong>Product Image:</strong>
                    @if ($product->product_image)
                    <img src="{{ asset($product->product_image) }}" alt="Product Image">
                    @else
                    No Image
                    @endif
                </div>
        
                @if ($product->product_gallery)
                <div class="form-group">
                    <strong>Gallery Images:</strong>
                    @foreach ($product->product_gallery as $galleryImage)
                    <img src="{{ asset($galleryImage) }}" alt="Gallery Image">
                    @endforeach
                </div>
                @else
                <div class="form-group">
                    <em>No Gallery Images</em>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection