@extends('layout')

@section('content')


<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center product-header">
                <h2 class="mb-0">Customer Details</h2>
                <a class="btn btn-primary btn-back" href="{{ route('customer.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    {{ $customer->customer_name }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>Customer Type:</strong>
                    {{ $customer->customer_type }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>Mobile Number:</strong>
                    {{ $customer->customer_phone }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    {{ $customer->customer_email ?: 'N/A' }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>Address:</strong>
                    {{ $customer->customer_address ?: 'N/A' }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>Postal Code:</strong>
                    {{ $customer->customer_postal_code ?: 'N/A' }}
                </div>
    
                <div class="col-md-6 mb-3">
                    <strong>City:</strong>
                    {{ $customer->customer_city }}
                </div>
                <div>
                    <strong>This customer was registered by:</strong> {{ $customer->registered_by }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
