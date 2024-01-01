@extends('layout')
@section('title', 'Categories')
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
    </style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('categories.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by Category name">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-primary" href="{{ route('categories.create') }}">Create New Category</a>
            <a class="btn btn-primary" href="{{ route('categories.parent') }}" >View All Parent Categories</a>
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
                <th scope="col">Category Name</th>
                <th scope="col">Parent Category</th>
                <th scope="col">Status</th>
                <th scope="col">Icon</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($childCategories as $childCategory)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $childCategory->name }}</td>
                    <td>
                        @if ($childCategory->category)
                            {{ $childCategory->category->name }}
                        @else
                            No Parent Category
                        @endif
                    </td>       
                    <td>{{ $childCategory->status }}</td>
                    <td>
                        @if ($childCategory->image)
                            <img src="{{ asset($childCategory->image) }}" alt="{{ $childCategory->name }}" width="50" height="50" class="img img-responsive">
                        @else
                            No Icon
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('categories.edit', $childCategory->id) }}">Edit</a>
                        <a class="btn btn-danger" href="{{ route('categories.destroy', $childCategory->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $childCategories->links() }}
    </div>
</div>

@endsection