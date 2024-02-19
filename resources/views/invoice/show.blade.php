@extends('layout')
@section('title', 'Invoice Details')
@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Invoice Information -->
        <div class="col-lg-6">
            <h2>Invoice</h2>
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice->date }}</p>
            <!-- Include other invoice details here -->
        </div>
        <!-- Logo -->
        <div class="col-lg-6 text-end">
            <img src="logo.png" alt="Company Logo" style="max-width: 150px;">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Bill From: (Company Details) -->
        <div class="col-lg-6">
            <h3>Bill From:</h3>
            <p>Company Name</p>
            <p>Address Line 1</p>
            <p>Address Line 2</p>
            <!-- Include other company details here -->
        </div>
        <!-- Bill To: (Customer Information) -->
        <div class="col-lg-6">
            <h3>Bill To:</h3>
            <p><strong>Customer Name:</strong> {{ $invoice->customer->customer_name }}</p>
            <p><strong>Customer Address:</strong> {{ $invoice->customer->customer_address }}</p>
            <p><strong>Customer Email:</strong> {{ $invoice->customer->customer_email }}</p>
            <!-- Include other customer details here -->
        </div>
    </div>

    <div class="row mt-3">
        <!-- Product Information -->
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Items</th>
                        <th>warranty</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_warranty }}</td>
                        <td>{{ $invoice->quantity[$loop->index] }}</td>
                        <td>{{ $product->price }}</td>
                        <td class="price">{{ $invoice->quantity[$loop->index] * $product->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Total:</td>
                        <td>{{ $invoice->total_price }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Terms and Conditions -->
        <div class="col-lg-6">
            <h3>Terms and Conditions</h3>
            <p>{{ $invoice->terms_and_conditions }}</p>
        </div>
        
        <!-- Payment Information -->
        <div class="col-lg-6">
            <h3>Payment Information</h3>
            <p><strong>Total Amount Paid:</strong> {{ $invoice->pay }}</p>
            <p><strong>Remaining Balance:</strong> {{ $invoice->due }}</p>
        </div>
    </div>
</div>
@endsection
