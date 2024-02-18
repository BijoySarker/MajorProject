@extends('layout')
@section('title', 'Invoice')
@section('content')

<style>
    .container {
        margin-top: 20px;
    }

    .table {
        margin-top: 20px;
    }

    .alert {
        margin-top: 20px;
    }

    .btn-create {
        margin-top: 20px;
    }

    .product-image {
        width: 50px;
        height: 50px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('invoice.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by Invoice Number">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-success" href="{{ route('invoice.create') }}">Create New Invoice</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th scope="col">SI</th>
                <th scope="col">Invoice Number</th>
                <th scope="col">Date</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Customer Number</th>
                <th scope="col">Total Price</th>
                <th scope="col">Paid</th>
                <th scope="col">Due</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $key => $invoice)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d M Y') }}</td>
                <td>{{ $invoice->customer->customer_name }}</td>
                <td>{{ $invoice->customer->customer_phone }}</td>
                <td>{{ $invoice->total_price }}</td>
                <td>
                    @if ($invoice->paid)
                    <span style="color: green;">&#10004;</span> <!-- Green checkmark -->
                    @else
                    <span style="color: red;">&#10008;</span> <!-- Red cross -->
                    @endif
                </td>
                <td>{{ $invoice->due }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('invoice.show', $invoice->id) }}">Show</a>
                    <a class="btn btn-warning" href="">Edit</a>
                    <a class="btn btn-danger" href="">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

    {{-- <div class="mt-3">
        {!! $invoices->links() !!}
    </div>
</div> --}}

@endsection

@section('scripts')
@endsection
