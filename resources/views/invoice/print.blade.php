<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- <link rel="stylesheet" href="style.css"> --}}
        <style>
            *,
            *::after,
            *::before{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            :root{
                --blue-color: #0c2f54;
                --dark-color: #535b61;
                --white-color: #fff;
            }

            ul{
                list-style-type: none;
            }
            ul li{
                margin: 2px 0;
            }

            /* text colors */
            .text-dark{
                color: var(--dark-color);
            }
            .text-blue{
                color: var(--blue-color);
            }
            .text-end{
                text-align: right;
            }
            .text-center{
                text-align: center;
            }
            .text-start{
                text-align: left;
            }
            .text-bold{
                font-weight: 700;
            }
            /* hr line */
            .hr{
                height: 1px;
                background-color: rgba(0, 0, 0, 0.1);
            }
            /* border-bottom */
            .border-bottom{
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            body{
                font-family: 'Poppins', sans-serif;
                color: var(--dark-color);
                font-size: 14px;
            }
            .invoice-wrapper{
                min-height: 100vh;
                background-color: rgba(0, 0, 0, 0.1);
                padding-top: 20px;
                padding-bottom: 20px;
            }
            .invoice{
                max-width: 850px;
                margin-right: auto;
                margin-left: auto;
                background-color: var(--white-color);
                padding: 70px;
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 5px;
                min-height: 920px;
            }
            .invoice-head-top-left img{
                width: 130px;
            }
            .invoice-head-top-right h3{
                font-weight: 500;
                font-size: 27px;
                color: var(--blue-color);
            }
            .invoice-head-middle, .invoice-head-bottom{
                padding: 16px 0;
            }
            .invoice-body{
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 4px;
                overflow: hidden;
            }
            .invoice-body table{
                border-collapse: collapse;
                border-radius: 4px;
                width: 100%;
            }
            .invoice-body table td, .invoice-body table th{
                padding: 12px;
            }
            .invoice-body table tr{
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }
            .invoice-body table thead{
                background-color: rgba(0, 0, 0, 0.02);
            }
            .invoice-body-info-item{
                display: grid;
                grid-template-columns: 80% 20%;
            }
            .invoice-body-info-item .info-item-td{
                padding: 12px;
                background-color: rgba(0, 0, 0, 0.02);
            }
            .invoice-foot{
                padding: 30px 0;
            }
            .invoice-foot p{
                font-size: 12px;
            }
            .invoice-btns{
                margin-top: 20px;
                display: flex;
                justify-content: center;
            }
            .invoice-btn{
                padding: 3px 9px;
                color: var(--dark-color);
                font-family: inherit;
                border: 1px solid rgba(0, 0, 0, 0.1);
                cursor: pointer;
            }

            .invoice-head-top, .invoice-head-middle, .invoice-head-bottom{
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                padding-bottom: 10px;
            }

            @media screen and (max-width: 992px){
                .invoice{
                    padding: 40px;
                }
            }

            @media screen and (max-width: 576px){
                .invoice-head-top, .invoice-head-middle, .invoice-head-bottom{
                    grid-template-columns: repeat(1, 1fr);
                }
                .invoice-head-bottom-right{
                    margin-top: 12px;
                    margin-bottom: 12px;
                }
                .invoice *{
                    text-align: left;
                }
                .invoice{
                    padding: 28px;
                }
            }

            .overflow-view{
                overflow-x: scroll;
            }
            .invoice-body{
                min-width: 600px;
            }

            @media print {
            .invoice-btns {
                display: none;
            }
        }
        </style>
    </head>
    <body>

        <div class = "invoice-wrapper" id = "print-area">
            <div class = "invoice">
                <div class = "invoice-container">
                    <div class = "invoice-head">
                        
                        <!-- Print Button -->
                        {{-- <div class="row mt-4">
                            <div class="col-lg-12 btn-print">
                                <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                            </div>
                        </div> --}}

                        <div class = "invoice-btns">
                            <button type = "button" class = "invoice-btn" onclick="window.print()">
                                <span>
                                    <i class="fa-solid fa-print"></i>
                                </span>
                                <span>Print</span>
                            </button>
                            <button type = "button" class = "invoice-btn">
                                <span>
                                    <i class="fa-solid fa-download"></i>
                                </span>
                                <span>Download</span>
                            </button>
                        </div>

                        <div class = "invoice-head-top">
                            <div class = "invoice-head-top-left text-start">
                                <img src = "{{ asset('storage/logo/demo_logo.jpg') }}">
                            </div>
                            <div class = "invoice-head-top-right text-end">
                                <h3>Invoice</h3>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-middle">
                            <div class = "invoice-head-middle-left text-start">
                                <p><span class = "text-bold">Date</span>: {{ \Carbon\Carbon::parse($invoice->date)->format('d F Y') }} </p>
                            </div>
                            <div class = "invoice-head-middle-right text-end">
                                <p><spanf class = "text-bold">Invoice No:</span> {{ $invoice->invoice_number }} </p>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-bottom">
                            <div class = "invoice-head-bottom-left">
                                <ul>
                                    <li class = 'text-bold'>Invoiced To:</li>
                                    <li> {{ $invoice->customer->customer_name }} </li>
                                    <li> {{ $invoice->customer->customer_address }} </li>
                                    <li> {{ $invoice->customer->customer_phone }} </li>
                                </ul>
                            </div>
                            <div class = "invoice-head-bottom-right">
                                <ul class = "text-end">
                                    <li class = 'text-bold'>Pay To:</li>
                                    <li>Koice Inc.</li>
                                    <li>2705 N. Enterprise</li>
                                    <li>Orange, CA 89438</li>
                                    <li>contact@koiceinc.com</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        <div class = "invoice-body">
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

                    <div class="row mt-3">
                        <!-- Payment Information -->
                        <div class="col-lg-6 invoice-head-top-right text-end">
                            <h3>Payment Information</h3>
                            <p><strong>Total Amount Paid:</strong> &#2547;{{ number_format($invoice->pay, 2, '.', ',') }}</p>
                            <p><strong>Remaining Balance:</strong> &#2547;{{ number_format($invoice->due, 2, '.', ',') }}</p>
                        </div>
                        <!-- Paid/Due Image -->
                        <div class="col-lg-6 invoice-head-top-left text-start">
                            <img src="{{ $invoice->paid ? asset('storage/paid/paid_image.webp') : asset('storage/paid/due_image.webp') }}" alt="{{ $invoice->paid ? 'Paid' : 'Due' }}" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                    <div class = "invoice-foot text-center">
                        <p><span class = "text-bold text-center">NOTE:&nbsp;</span>{{ strip_tags($invoice->terms_and_conditions) }}</p>

                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
