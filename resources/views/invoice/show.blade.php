@extends('layout')
@section('title', 'Invoice Details')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h2>Invoice Details</h2>
            <p>Invoice Number: {{ $invoice->invoice_number }}</p>
            <!-- Other invoice details display here -->
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <h3>Products</h3>
            <table class="table table-bordered" id="selected_products_table">
                <!-- Table header -->
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
                <!-- Table body -->
                <tbody id="selected_products_body"></tbody>
                <!-- Table footer -->
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">Total:</td>
                        <td id="total_price">0.00</td>
                        <input type="hidden" name="total_price" id="total_price_input">
                    </tr>
                    <!-- Other footer rows -->
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
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
        // Decode JSON-encoded product IDs and quantities
        var productIds = JSON.parse($('#product_ids').val());
        var quantities = JSON.parse($('#quantity').val());

        // Loop through each product ID and quantity to display the products in the table
        for (var i = 0; i < productIds.length; i++) {
            var productId = productIds[i];
            var quantity = quantities[i];
            $.ajax({
                url: '{{ route('get-product-details') }}',
                method: 'GET',
                data: { productId: productId },
                success: function (productDetails) {
                    $('#selected_products_body').append(`
                        <tr data-product-id="${productId}">
                            <td>${productDetails.product_name}</td>
                            <td><img src="${productDetails.image}" alt="${productDetails.product_name}" style="max-width: 100px;"></td>
                            <td>${quantity}</td>
                            <td>${productDetails.price}</td>
                            <td class="price">${quantity * productDetails.price}</td>
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${productId})">Remove</button></td>
                        </tr>
                    `);
                }
            });
        }

        // Remove selected product
        $('#selected_products_body').on('click', 'button.btn-danger', function () {
            var productId = $(this).closest('tr').data('product-id');
            removeProduct(productId);
            updateTotalPrice();
            updateDueAmount();
            updateHiddenInputs();
        });

        // Function to update total price
        function updateTotalPrice() {
            var total = 0;
            $('#selected_products_body tr').each(function () {
                total += parseFloat($(this).find('.price').text());
            });

            $('#total_price').text(total.toFixed(2));
        }

        // Function to update due amount
        function updateDueAmount() {
            var total = parseFloat($('#total_price').text());
            var payment = parseFloat($('#payment_input').val()) || 0;
            var due = total - payment;
            $('#due_amount').text(due.toFixed(2));

            var paid = due === 0 ? 1 : 0;
            $('#paid').val(paid);
        }

        function removeProduct(productId) {
            $('tr[data-product-id="' + productId + '"]').remove();
            updateTotalPrice();
            updateDueAmount();
            updateHiddenInputs();
        }

        updateTotalPrice();
        updateDueAmount();
        updateHiddenInputs();
    });
</script>

@endsection