@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center product-header">
                    <h2 class="mb-0">Edit Customer</h2>
                    <a class="btn btn-primary btn-back" href="{{ route('customer.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <strong>Error!</strong> <br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Use 'PUT' method for update --}}
        
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_name">Customer Name:</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ $customer->customer_name }}" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_type">Customer Type:</label>
                        <select name="customer_type" class="form-control" required>
                            <option value="General" {{ $customer->customer_type === 'General' ? 'selected' : '' }}>General</option>
                            <option value="Dealer" {{ $customer->customer_type === 'Dealer' ? 'selected' : '' }}>Dealer</option>
                            <option value="Corporate" {{ $customer->customer_type === 'Corporate' ? 'selected' : '' }}>Corporate</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="registered_by">Registered By:</label>
                        <select name="registered_by" class="form-control" required>
                            <option value="" disabled>Select Name</option>
                            @foreach($users as $user)
                                <option value="{{ $user->name }}" {{ $user->id === $customer->registered_by ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_phone">Customer Phone:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input type="text" name="customer_phone" class="form-control"
                                   value="{{ $customer->customer_phone }}" required pattern="[0-9]{11}" maxlength="11" inputmode="numeric">
                        </div>
                        <small class="text-muted">Enter a valid 11-digit phone number.</small>
                    </div>
                </div>

                <!-- Other form fields... -->

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_city">Select City:</label>
                        <select name="customer_city" class="form-control" required>
                            <option value="" disabled>Select City</option>
                            <option value="Dhaka" {{ $customer->customer_city === 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                            <!-- Other city options... -->
                        </select>
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
