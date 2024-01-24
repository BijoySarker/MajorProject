@foreach ($customers as $customer)
    <li class="list-group-item" data-customer-id="{{ $customer->id }}" data-customer-name="{{ $customer->customer_name }}">
        {{ $customer->customer_name }}
    </li>
@endforeach