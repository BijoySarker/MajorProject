@extends('layout')

@section('content')

<style>
    /* Add your custom CSS styles here */
    .category-container {
        margin-top: 4rem;
    }

    .category-item {
        margin-bottom: 1.5rem;
        border: 1px solid #ddd;
        padding: 1rem;
    }
</style>
    <div class="container mt-4">
        <h2 class="mb-4">All Parent Categories</h2>

        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Add New Category</h2>
                <a class="btn btn-primary" href="{{ route('categories.index') }}">Back</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('categories.delete', $category->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection