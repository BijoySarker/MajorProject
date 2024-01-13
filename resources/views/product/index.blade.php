@extends('layout')
@section('title', 'Products')
@section('content')

<style>
    .container {
        margin-top: 20px;
    }

    .table {
        margin-top: 20px;
    }

    .alert {
        margin-top: 20px;
    }

    .btn-create {
        margin-top: 20px;
    }

    .product-image {
        width: 50px;
        height: 50px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('products.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by product name">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-success" href="{{ route('products.create') }}">Create New Product</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th scope="col">SI</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Brand</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ ++$i }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        @if ($product->product_image)
                        <img src="{{ asset($product->product_image) }}" alt="Product Image" class="product-image mr-3">
                        @endif
                        <span>{{ $product->product_name }}</span>
                    </div>
                </td>
                <td>{{ $product->product_quantity }}</td>
                <td>&#2547;{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->category }}</td>
                <td>
                    @if ($product->brand)
                    @php
                    $brand = \App\Models\Brand::find($product->brand);
                    @endphp
                    @if ($brand && $brand->image)
                    <img src="{{ asset($brand->image) }}" alt="Brand Image" class="product-image">
                    @else
                    No Image
                    @endif
                    @else
                    No Brand
                    @endif
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ route('product.show', $product->id) }}">Show</a>
                    <a class="btn btn-warning" href="{{ route('product.edit', $product->id) }}">Edit</a>
                    <a class="btn btn-danger" href="{{ route('product.destroy', $product->id) }}">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {!! $products->links() !!}
    </div>
</div>

@endsection

@section('scripts')
@endsection