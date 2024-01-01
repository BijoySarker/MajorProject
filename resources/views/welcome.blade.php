@extends('layout')

@section('title', 'MoajorProject')

{{-- @section('content')
@endsection --}}
@section('dashboard')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Welcome to the Dashboard, {{ auth()->user()->name }}!</h2>
                <p>Choose an action below:</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg btn-block">View Products</a>
            </div>
            <div class="col-lg-4">
                <a href="{{ route('categories.index') }}" class="btn btn-success btn-lg btn-block">View Categories</a>
            </div>
            <div class="col-lg-4">
                <a href="{{ route('brand.index') }}" class="btn btn-info btn-lg btn-block">View Brands</a>
            </div>
            <!-- Add more buttons as needed -->
        </div>
    </div>
@endsection
