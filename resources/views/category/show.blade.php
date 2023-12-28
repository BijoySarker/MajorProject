@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-4">{{ $childCategory->name }}</h2>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Details</h5>
                        <p class="card-text"><strong>Parent Category:</strong> {{ $childCategory->category->name }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst($childCategory->status) }}</p>
                        <p class="card-text"><strong>Icon:</strong></p>
                        @if ($childCategory->image)
                            <img src="{{ asset('storage/' . $childCategory->image) }}" alt="Child Category Image" class="img-fluid mb-3">
                        @else
                            <p class="card-text">No image available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection