@extends('layout')
@section('title', 'Quotation Create')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Add New Quotation</h2>
            <a class="btn btn-primary" href="{{ route('quotation.index') }}">Back</a>
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

    <form method="POST" action="{{ route('quotation.store') }}">
        @csrf

                        <div class="custom-form-group">
                            <label for="quotation_number">Quotation Number</label>
                            <input type="text" class="form-control custom-input" id="quotation_number" name="quotation_number" readonly>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="product_id[]" id="product_id">
                        </div>

                        <div class="form-group">
                            <label for="product_search">Product Search:</label>
                            <input type="text" class="form-control" id="product_search" placeholder="Search for products">
                            <ul id="product_results" class="list-group"></ul>
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
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group">
                            <label for="quotation_type">Select Quotation Type:</label>
                            <select name="quotation_type" id="quotation_type" class="form-control">
                                <option value="0">Dealer</option>
                                <option value="1">Corporate</option>
                            </select>
                        </div>

                            <div class="form-group">
                                <label for="company_persons">Enter Company Persons:</label>
                                <input type="text" name="company_persons" id="company_persons" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="company_name">Enter Company Name:</label>
                                <input type="text" name="company_name" id="company_name" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="company_address">Enter Company Address:</label>
                                <input type="text" name="company_address" id="company_address" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="quotation_subject">Enter Subject:</label>
                                <input type="text" name="quotation_subject" id="quotation_subject" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="attention_quot">Enter Attention:</label>
                                <input type="text" name="attention_quot" id="attention_quot" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="dear_sir">Dear Sir:</label>
                                <input type="text" name="dear_sir" id="dear_sir" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="quotation_body">Enter Quotation Body:</label>
                                <textarea name="quotation_body" id="quotation_body" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="terms_and_condition">Terms and Conditions</label>
                                <textarea id="terms_and_condition" name="terms_and_condition"></textarea>
                            </div>

                        <button type="submit" class="btn btn-primary">Create Quotation</button>
                    </form>
                </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        CKEDITOR.replace('terms_and_condition');
    });
</script>

<script>
    $(document).ready(function () {
        $('#product_search').on('input', function () {
            var query = $(this).val();

            if (query.length >= 3) {
                $.ajax({
                    url: '/search-products',
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
                url: '/get-product-details',
                method: 'GET',
                data: { productId: productId },
                success: function (productDetails) {
                    // Update form fields with selected product details
                    var existingIds = $('#product_id').val() ? JSON.parse($('#product_id').val()) : [];
                    existingIds.push(productId);

                    $('#product_id').val(JSON.stringify(existingIds));
                    
                    // Convert the stored JSON string to an array
                    var storedIdsArray = JSON.parse($('#product_id').val());

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
        });

        // Remove selected product
        $('#selected_products_body').on('click', 'button.btn-danger', function () {
            var productId = $(this).closest('tr').data('product-id');
            removeProduct(productId);
            updateTotalPrice();
        });

        // Update total price on quantity or unit price change
        $('#selected_products_body').on('input', '.quantity, .unit-price', function () {
            updateTotalPrice();
        });
    });

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

        // Update total price in the last row
        $('#total_price').text(total.toFixed(2));
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function generateQuotationNumber() {
            var randomNumber = Math.floor(100000 + Math.random() * 900000);
            var quotationNumber = "MP" + randomNumber;
            return quotationNumber;
        }

        document.getElementById('quotation_number').value = generateQuotationNumber();
    });
</script>

<style>
    .custom-form-group {
        width: 200px;
        margin-bottom: 10px;
    }

    .custom-input {
        width: 100%;
        height: 30px;
    }
</style>


@endsection