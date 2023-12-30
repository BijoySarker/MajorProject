@extends('layout')
@section('title', 'Brand')
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
            <form action="{{ route('brand.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by brand name">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-success" href="{{ route('brand.create') }}">Create New Brand</a>
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
                <th scope="col">Brand Name</th>
                <th scope="col">Image</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($brands as $brand)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        @if ($brand->image)
                            <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" width="50" height="50" class="img img-responsive">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('brand.edit', $brand->id) }}">Edit</a>
                        <a class="btn btn-danger" href="{{ route('brand.destroy', $brand->id) }}">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No brands available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {!! $brands->links() !!}
    </div>
</div>

@endsection