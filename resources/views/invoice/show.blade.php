@extends('layout')
@section('title', 'Invoice Details')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h2>Invoice Details</h2>
            <a class="btn btn-primary" href="{{ route('invoice.index') }}">Back</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-6">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->date }}</p>
            <p><strong>Customer:</strong> {{ $invoice->customer ? $invoice->customer->customer_name : 'N/A' }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($invoice->products()->sum('price'), 2) }}</p>

            <p><strong>Due:</strong> ${{ number_format($invoice->due, 2) }}</p>
            <p><strong>Terms and Conditions:</strong> {{ $invoice->terms_and_conditions ?: 'N/A' }}</p>
            <!-- Add other invoice details here -->
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <h3>Products</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>${{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
