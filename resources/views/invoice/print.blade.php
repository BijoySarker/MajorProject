<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Adjust margins */
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        
        /* Additional styles for invoice details */
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
        }

        .btn-print {
            margin-top: 20px;
            text-align: center;
        }

        .payment-info {
            text-align: right;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo and Invoice Title -->
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ asset('storage/logo/demo_logo.jpg') }}" alt="Company Logo" style="max-width: 150px;">
            </div>
            <div class="col-lg-6 text-right">
                <h1>Invoice</h1>
            </div>
        </div>
        
        <!-- Bill To Section -->
        <div class="row ">
            <div class="col-lg-6">
                <h3>Customer Information:</h3>
                <p><strong>Name:</strong> {{ $invoice->customer->customer_name }}</p>
                <p><strong>Address:</strong> {{ $invoice->customer->customer_address }}</p>
                <p><strong>Number:</strong> {{ $invoice->customer->customer_phone }}</p>
            </div>
            <div class="col-lg-6">
                <div class="text-right">
                    <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }} </strong></p>
                </div>
            </div>
        </div>
        
        <!-- Product Information -->
        <div class="row mt-3">
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
                            <td colspan="5" class="text-right"><strong>Total Price:</strong></td>
                            <td>&#2547;{{ number_format($invoice->total_price, 2, '.', ',') }}</td>
                        </tr>
                    </tfoot>
                </table>           
            </div>
        </div>

        <!-- Payment Information -->
        <div class="row mt-4 payment-info">
            <div class="col-lg-6">
                <img src="{{ $invoice->paid ? asset('storage/paid/paid_image.webp') : asset('storage/paid/due_image.webp') }}" alt="{{ $invoice->paid ? 'Paid' : 'Due' }}" style="max-width: 200px;">
            </div>
            <div class="col-lg-6">
                <h3>Payment Information</h3>
                <p><strong>Total Amount Paid:</strong> &#2547;{{ number_format($invoice->pay, 2, '.', ',') }}</p>
                <p><strong>Remaining Balance:</strong> &#2547;{{ number_format($invoice->due, 2, '.', ',') }}</p>
            </div>
        </div>
        
        <!-- Terms and Conditions -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <h3>Terms and Conditions</h3>
                <p>{{ strip_tags($invoice->terms_and_conditions) }}</p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="row mt-4">
            <div class="col-lg-12 btn-print">
                <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
            </div>
        </div>
    </div>
</body>
</html>
