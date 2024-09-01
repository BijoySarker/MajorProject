<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice</title>
    <meta name="description" content="Invoice">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        *,
        *::after,
        *::before {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        :root {
            --blue-color: #0c2f54;
            --dark-color: #535b61;
            --white-color: #fff;
            --border-color: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .invoice-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 295mm; /* A4 height */
            padding-bottom: 10mm; /* Adjusted to allow space for footer */
        }

        .invoice-head-top-left img {
            width: 100px;
        }

        .invoice-head-top-right h3 {
            font-weight: 600;
            font-size: 20px;
            color: var(--blue-color);
            margin-bottom: 0;
        }

        .invoice-head-middle {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 12px;
        }

        .invoice-head-bottom {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 12px;
        }

        .invoice-head-bottom ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .invoice-head-bottom ul li {
            margin: 2px 0;
        }

        .invoice-body {
            margin-top: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            font-size: 11px;
        }

        .invoice-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .invoice-body table td,
        .invoice-body table th {
            padding: 8px;
            border: 1px solid var(--border-color);
            text-align: right;
        }

        .invoice-body table th {
            background-color: var(--blue-color);
            color: var(--white-color);
            text-align: center;
        }

        .invoice-body table td {
            text-align: left;
        }

        .invoice-foot {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid var(--border-color);
            font-size: 11px;
        }

        .invoice-btns {
            margin: 15px 0;
            text-align: center;
        }

        .invoice-btn {
            padding: 8px 12px;
            margin: 0 5px;
            color: var(--dark-color);
            border: 1px solid var(--border-color);
            background-color: var(--white-color);
            cursor: pointer;
            font-size: 12px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .invoice-btn:hover {
            background-color: var(--border-color);
        }

        .invoice-payment-info {
            margin-top: 15px;
            font-size: 11px;
        }

        .invoice-payment-image img {
            max-height: 80px;
            display: block;
            margin: 10px auto;
        }

        .invoice-footer {
            width: 100%;
            position: absolute;
            bottom: 15mm;
            left: 0;
            padding: 5px 15mm;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--border-color);
            font-size: 10px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: auto;
            padding-top: 5px;
            border-top: 1px solid var(--border-color);
            font-size: 11px;
        }

        .signature-section div {
            width: 45%;
            text-align: center;
        }

        .signature-section div p {
            margin-top: 30px;
            border-top: 1px solid var(--border-color);
            padding-top: 5px;
            font-weight: 500;
        }

        .company-info {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        @media print {
            body {
                margin: 0;
            }

            .invoice-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
            }

            .invoice-btns {
                display: none;
            }

            .invoice-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
            }

            .signature-section div p {
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

    <div id="print-area">
        <div class="invoice">
            <div class="invoice-head">
                <div class="invoice-head-top">
                    <div class="invoice-head-top-left">
                        <img src="{{ asset('storage/logo/demo_logo.jpg') }}" alt="Company Logo">
                    </div>
                    <div class="invoice-head-top-right text-end">
                        <h3>Invoice</h3>
                    </div>
                </div>
                <div class="invoice-head-middle">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }}</p>
                    <p><strong>Invoice No:</strong> {{ $invoice->invoice_number }}</p>
                </div>
                <div class="invoice-head-bottom">
                    <div class="invoice-head-bottom-left">
                        <ul>
                            <li class="text-bold">Invoiced To:</li>
                            <li>{{ $invoice->customer->customer_name }}</li>
                            <li>{{ $invoice->customer->customer_address }}</li>
                            <li>{{ $invoice->customer->customer_phone }}</li>
                        </ul>
                    </div>
                    <div class="invoice-head-bottom-right text-end">
                        <ul>
                            <li class="text-bold">Pay To:</li>
                            <li>Koice Inc.</li>
                            <li>2705 N. Enterprise</li>
                            <li>Orange, CA 89438</li>
                            <li>contact@koiceinc.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="invoice-body">
                <table>
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
            <div class="invoice-payment-info">
                <h4>Payment Information</h4>
                <p><strong>Total Amount Paid:</strong> &#2547;{{ number_format($invoice->pay, 2, '.', ',') }}</p>
                <p><strong>Remaining Balance:</strong> &#2547;{{ number_format($invoice->due, 2, '.', ',') }}</p>
            </div>
            <div class="invoice-payment-image">
                <img src="{{ $invoice->paid ? asset('storage/paid/paid_image.webp') : asset('storage/paid/due_image.webp') }}" alt="{{ $invoice->paid ? 'Paid' : 'Due' }}">
            </div>
            <div class="invoice-foot">
                <p><strong>NOTE:</strong> {{ strip_tags($invoice->terms_and_conditions) }}</p>
            </div>
            <div class="signature-section">
                <div>
                    <p>Customer Signature</p>
                </div>
                <div>
                    <p>Authorized Signature</p>
                </div>
            </div>
            <div class="company-info">
                <p>Company Address: 2705 N. Enterprise, Orange, CA 89438</p>
                <p>Mobile: +1 234-567-8901 | Email: contact@koiceinc.com</p>
            </div>
            <div class="invoice-btns">
                <button type="button" class="invoice-btn" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <button type="button" id="download-pdf" class="invoice-btn">
                    <i class="fa-solid fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>

</body>
</html>
