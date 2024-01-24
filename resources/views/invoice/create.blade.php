@extends('layout')
@section('title', 'Invoice Create')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Add New Invoice</h2>
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
                <form method="POST" action="{{ route('invoice.store') }}">
                    @csrf

                    <div class="custom-form-group">
                        <label for="invoice_number">Invoice Number</label>
                        <input type="text" class="form-control custom-input" id="invoice_number" name="invoice_number" readonly>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ now()->format('Y-m-d') }}" placeholder="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label for="customer_search">Search for Customer:</label>
                        <input type="text" class="form-control" id="customer_search" placeholder="Search for customers">
                        <ul id="customer_results" class="list-group"></ul>
                        <input type="hidden" name="customer_id" id="customer_id">
                    </div>

                    <div class="form-group">
                        <label for="product_search">Search for Products:</label>
                        <input type="text" class="form-control" id="product_search" placeholder="Search for products">
                        <ul id="product_results" class="list-group"></ul>
                        <input type="hidden" name="product_ids" id="product_ids">
                    </div>

                    <div class="form-group">
                        <table class="table table-bordered" id="selected_products_table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="selected_products_body"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">Total:</td>
                                    <td id="total_price">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">Payment:</td>
                                    <td>
                                        <input type="number" class="form-control" id="payment_input" value="0.00" step="0.01">
                                    </td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="4" class="text-end">Due:</td>
                                    <td id="due_amount">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function generateInvoiceNumber() {
                var randomNumber = Math.floor(100000 + Math.random() * 900000);
                var invoiceNumber = "INV" + randomNumber;
                return invoiceNumber;
            }
    
            document.getElementById('invoice_number').value = generateInvoiceNumber();
        });
    
        $(document).ready(function () {
            // Customer search functionality
            $('#customer_search').on('input', function () {
                var query = $(this).val();
    
                if (query.length >= 3) {
                    $.ajax({
                        url: '/search-customers',
                        method: 'GET',
                        data: { query: query },
                        success: function (data) {
                            $('#customer_results').html(data);
                        }
                    });
                }
            });
    
            $('#customer_results').on('click', '.list-group-item', function () {
                var customerId = $(this).data('customer-id');
                var customerName = $(this).data('customer-name');
    
                $('#customer_search').val(customerName);
                $('#customer_id').val(customerId);
                $('#customer_results').html('');
            });
    
            // Product search functionality
            $('#product_search').on('input', function () {
                var query = $(this).val();
    
                if (query.length >= 3) {
                    $.ajax({
                        url: '{{ route('search-products') }}',
                        method: 'GET',
                        data: { query: query },
                        success: function (data) {
                            $('#product_results').html(data);
                        }
                    });
                }
            });
    
            $('#product_results').on('click', '.list-group-item', function () {
                var productId = $(this).data('product-id');
                var productName = $(this).data('product-name');
    
                $.ajax({
                    url: '{{ route('get-product-details') }}',
                    method: 'GET',
                    data: { productId: productId },
                    success: function (productDetails) {
                        var existingIds = $('#product_ids').val() ? JSON.parse($('#product_ids').val()) : [];
                        existingIds.push(productId);
    
                        // Set the product_ids field as an array
                        $('#product_ids').val(JSON.stringify(existingIds));
    
                        // Use the stored array directly, no need to parse again
                        $('#selected_products_body').append(`
                            <tr data-product-id="${productId}">
                                <td>${productName}</td>
                                <td><img src="${productDetails.image}" alt="${productName}" style="max-width: 100px;"></td>
                                <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                                <td><input type="number" name="unit_price[]" class="form-control unit-price" value="${productDetails.price}" required></td>
                                <td class="price">0</td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${productId})">Remove</button></td>
                            </tr>
                        `);
                    }
                });
    
                $('#product_search').val('');
                $('#product_results').html('');
            });
    
            // Remove selected product
            $('#selected_products_body').on('click', 'button.btn-danger', function () {
                var productId = $(this).closest('tr').data('product-id');
                removeProduct(productId);
                updateTotalPrice();
            });
    
            $('#payment_input').on('input', function () {
                updateDueAmount();
            });
    
            // Update total price on quantity or unit price change
            $('#selected_products_body').on('input', '.quantity, .unit-price', function () {
                updateTotalPrice();
                updateDueAmount();
            });
    
            // New function to update due amount
            function updateDueAmount() {
                var total = parseFloat($('#total_price').text());
                var payment = parseFloat($('#payment_input').val()) || 0; // Use the input value
                var due = total - payment;
                $('#due_amount').text(due.toFixed(2));
            }
    
            function removeProduct(productId) {
                $('[data-product-id="' + productId + '"]').remove();
            }
    
            function updateTotalPrice() {
                var total = 0;
                $('#selected_products_body tr').each(function () {
                    var quantity = parseFloat($(this).find('.quantity').val());
                    var unitPrice = parseFloat($(this).find('.unit-price').val());
                    var price = quantity * unitPrice;
                    total += price;
                    $(this).find('.price').text(price.toFixed(2));
                });
    
                $('#total_price').text(total.toFixed(2));
            }
        });
    </script>
    
@endsection
