@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center product-header">
                <h2 class="mb-0">Customer Details</h2>
                <a class="btn btn-primary btn-back" href="{{ route('customer.index') }}">Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <span class="customer-info">{{ $customer->customer_name }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Customer Type:</strong>
                        <span class="customer-info">{{ $customer->customer_type }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Mobile Number:</strong>
                        <span class="customer-info">{{ $customer->customer_phone }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <span class="customer-info">{{ $customer->customer_email ?: 'N/A' }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Address:</strong>
                        <span class="customer-info">{{ $customer->customer_address ?: 'N/A' }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Postal Code:</strong>
                        <span class="customer-info">{{ $customer->customer_postal_code ?: 'N/A' }}</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>City:</strong>
                        <span class="customer-info">{{ $customer->customer_city }}</span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Registered By:</strong> 
                        <span class="customer-info">{{ $customer->registered_by }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .product-header h2 {
        color: #333;
        font-weight: 600;
    }

    .btn-back {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-back:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .customer-info {
        font-size: 1.1rem;
        color: #555;
        display: block;
        margin-top: 5px;
    }

    .customer-info::before {
        content: '• ';
        color: #007bff;
        font-weight: bold;
    }

    .card {
        animation: fadeInUp 0.5s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const backButton = document.querySelector('.btn-back');
        backButton.addEventListener('mouseover', function () {
            backButton.classList.add('hovered');
        });

        backButton.addEventListener('mouseleave', function () {
            backButton.classList.remove('hovered');
        });
    });
</script>
@endsection
