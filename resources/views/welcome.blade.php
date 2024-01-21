@extends('layout')

@section('title', 'Major Project Dashboard')

@section('dashboard')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Welcome to the Dashboard, {{ auth()->user()->name }}!</h2>
                <p>Explore and manage business with ease.</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Total Customers</h4>
                        {{-- <p class="card-text">Check how many customers you have.</p> --}}
                        <a href="{{ route('customer.index') }}" class="btn btn-primary">View Customers</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Total Products</h4>
                        {{-- <p class="card-text">Explore your product inventory.</p> --}}
                        <a href="{{ route('products.index') }}" class="btn btn-success">View Products</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Total Orders</h4>
                        {{-- <p class="card-text">Manage and track your orders.</p> --}}
                        <a href="" class="btn btn-info">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="card-title">Total Sales</h4>
                        {{-- <p class="card-text">Review your sales performance.</p> --}}
                        <a href="" class="btn btn-warning">View Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
