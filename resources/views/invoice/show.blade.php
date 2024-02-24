@extends('layout')
@section('title', 'Invoice Details')
@section('content')
<div class="container mt-4">
    <div class="row mt-4">
        <div class="col-lg-12">
            <button class="btn btn-primary" onclick="window.open('{{ route('invoice.print', $invoice->id) }}', '_blank')">Print Invoice</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Invoice</h2>
            <a class="btn btn-primary" href="{{ route('invoice.index') }}">Back</a>
        </div>
    </div>
    <div class="row">
        <!-- Invoice Information -->
        <div class="col-lg-6">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }}</p>
        </div>
        <!-- Logo -->
        <div class="col-lg-6 text-end">
            <img src="{{ asset('storage/logo/demo_logo.jpg') }}" alt="Company Logo" style="max-width: 150px;">
        </div>
    </div>

    <div class="row mt-3">
        <!-- Bill To: (Customer Information) -->
        <div class="col-lg-6">
            <h3>Bill To:</h3>
            <p><strong>Customer Name:</strong> {{ $invoice->customer->customer_name }}</p>
            <p><strong>Customer Address:</strong> {{ $invoice->customer->customer_address }}</p>
            <p><strong>Customer Number:</strong> {{ $invoice->customer->customer_phone }}</p>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Product Information -->
        <div class="col-lg-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SI</th>
                        <th>Items</th>
                        <th>Warranty</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_warranty }}</td>
                        <td>{{ $invoice->quantity[$loop->index] }}</td>
                        <td>{{ number_format($product->price, 2, '.', ',') }}</td>
                        <td>{{ number_format($invoice->quantity[$loop->index] * $product->price, 2, '.', ',') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Total Price:</strong></td>
                        <td>&#2547;{{ number_format($invoice->total_price, 2, '.', ',') }}</td>
                    </tr>
                </tfoot>
            </table>           
        </div>
    </div>

    <div class="row mt-3">
        <!-- Payment Information -->
        <div class="col-lg-6">
            <h3>Payment Information</h3>
            <p><strong>Total Amount Paid:</strong> &#2547;{{ number_format($invoice->pay, 2, '.', ',') }}</p>
            <p><strong>Remaining Balance:</strong> &#2547;{{ number_format($invoice->due, 2, '.', ',') }}</p>
        </div>
        <!-- Paid/Due Image -->
        <div class="col-lg-3 text-end">
            @if($invoice->paid)
                <img src="{{ asset('storage/paid/paid_image.webp') }}" alt="Paid" style="max-width: 200px;">
            @else
                <img src="{{ asset('storage/paid/due_image.webp') }}" alt="Due" style="max-width: 200px;">
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <!-- Terms and Conditions -->
        <div class="col-lg-6">
            <h3>Terms and Conditions</h3>
            <p>{{ strip_tags($invoice->terms_and_conditions) }}</p>
        </div>
    </div>
    
</div>
@endsection
