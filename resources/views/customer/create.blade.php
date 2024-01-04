@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Add New Customer</h2>
                <a class="btn btn-primary" href="{{ route('customer.index') }}">Back</a>
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

        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_name">Customer Name:</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Name" required>
                    </div>
                </div>
        
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_type">Customer Type:</label>
                        <select name="customer_type" class="form-control" required>
                            <option value="General">General</option>
                            <option value="Dealer">Dealer</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                    </div>
                </div>
        
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="registered_by">Registered By:</label>
                        <select name="registered_by" class="form-control" required>
                            <option value="" disabled selected>Select Name</option>
                            @foreach($users as $user)
                                <option value="{{ $user->name }}">{{ $user->name }}</option>
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
                            <input type="text" name="customer_phone" class="form-control" placeholder="Customer Phone" required pattern="[0-9]{11}" maxlength="11" inputmode="numeric">
                        </div>
                        <small class="text-muted">Enter a valid 11-digit phone number.</small>
                    </div>
                </div>
                

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_email">Customer Email:</label>
                        <input type="email" name="customer_email" class="form-control" placeholder="Email">
                    </div>
                </div>
        
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_address">Customer Address:</label>
                        <input type="text" name="customer_address" class="form-control" placeholder="Address">
                    </div>
                </div>
        
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_postal_code">Customer Postal Code:</label>
                        <input type="text" name="customer_postal_code" class="form-control" placeholder="Postal Code">
                    </div>
                </div>
        
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="customer_city">Customer City:</label>
                        <select name="customer_city" class="form-control" required>
                            <option value="" disabled selected>Select City</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Chattogram">Chattogram</option>
                            <option value="Khulna">Khulna</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Gazipur">Gazipur</option>
                            <option value="Sylhet">Sylhet</option>
                            <option value="Mymensingh">Mymensingh</option>
                            <option value="Rangpur">Rangpur</option>
                            <option value="Cumilla">Cumilla</option>
                            <option value="Barisal">Barisal</option>
                            <option value="Narayanganj">Narayanganj</option>
                        </select>
                    </div>
                </div>
        
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Ensure that the value always starts with +880
        document.addEventListener('DOMContentLoaded', function () {
            var customerPhoneInput = document.querySelector('input[name="customer_phone"]');
            
            customerPhoneInput.addEventListener('blur', function () {
                if (!customerPhoneInput.value.startsWith('+880')) {
                    customerPhoneInput.value = customerPhoneInput.value;
                }
            });
        });
    </script>
@endsection