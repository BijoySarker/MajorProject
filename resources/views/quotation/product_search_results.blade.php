@foreach ($products as $product)
    <li class="list-group-item" data-product-id="{{ $product->id }}" data-product-name="{{ $product->product_name }}">
        {{ $product->product_name }}
    </li>
@endforeach 