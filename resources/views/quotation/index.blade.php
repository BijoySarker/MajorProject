@extends('layout')
@section('title', 'Quotations')
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
            <form action="{{ route('quotation.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by Quotation name">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-success" href="{{ route('quotation.create') }}">Create New Quotation</a>
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
                <th scope="col">Quotation Number</th>
                <th scope="col">Total Products</th>
                <th scope="col">Total Price</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $serialNumber = 1; @endphp
            @foreach ($quotations as $quotation)
                <tr>
                    <td>{{ $serialNumber++ }}</td>
                    <td>{{ $quotation->quotation_number }}</td>
                    <td>
                         @if ($quotation->product_id)
                             {{ json_encode($quotation->product_id) }}
                         @else
                             No Products
                         @endif
                     </td>
                     <td>{{ $quotation->product_price }}</td>
                    <td>
                        {{-- Add other actions as needed --}}
                        {{-- <a href="{{ route('quotation.show', $quotation->id) }}" class="btn btn-primary">View</a> --}}
                        <a class="btn btn-danger" href="{{ route('quotation.destroy', $quotation->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {!! $quotations->links() !!}
    </div>
</div>

@endsection

@section('scripts')
@endsection