@extends('layout')

@section('title', 'Edit Invoice')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Edit Invoice</h2>
            <a class="btn btn-primary" href="{{ route('invoice.index') }}">Back</a>
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

    <div class="row mt-3">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('invoice.update', $invoice->id) }}">
                @csrf
                @method('PUT')

                <!-- Invoice Number and Date -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $invoice->invoice_number }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $invoice->date }}" placeholder="Select date">
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select class="form-control" id="customer_id" name="customer_id">
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Selected Products Table -->
                <div class="form-group">
                    <table class="table table-bordered" id="selected_products_table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="selected_products_body">
                            @foreach ($selectedProducts as $product)
                            <tr data-product-id="{{ $product->id }}">
                                <td>{{ $product->product_name }}</td>
                                <td><input type="number" name="quantity[]" class="form-control quantity" value="{{ $invoice->quantity[$loop->index] }}" required></td>
                                <td><input type="number" name="unit_price[]" class="form-control unit-price" value="{{ $product->price }}" required></td>
                                <td class="price">{{ $invoice->quantity[$loop->index] * $product->price }}</td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct({{ $product->id }})">Remove</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Total:</td>
                                <td id="total_price">{{ $invoice->total_price }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-group">
                    <label for="terms_and_conditions">Terms and Conditions</label>
                    <textarea id="terms_and_conditions" name="terms_and_conditions">{{ $invoice->terms_and_conditions }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
