@extends('layout')
@section('title', 'Products')
@section('content')



<style>
        /* Add your custom styling here */

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
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Brand</th>
                <th scope="col">Warranty</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
        <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->category }}</td>
        <td>
            @if ($product->brand)
                @php
                    $brand = \App\Models\Brand::find($product->brand);
                @endphp
                @if ($brand && $brand->image)
                    <img src="{{ asset($brand->image) }}" alt="Brand Image" width="50" height="50">
                @else
                    No Image
                @endif
            @else
                No Brand
            @endif
        </td>
        <td>{{ $product->product_warranty }}</td>
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
    <script>
        function confirmDelete(productName, productId) {
            if (confirm('Are you sure you want to delete ' + productName + '?')) {
                window.location.href = '/products/destroy/' + productId;
            }
        }
    </script>
@endsection