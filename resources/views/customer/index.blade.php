@extends('layout')
@section('title', 'Customer')
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
    </style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('customer.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by Customer name">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-lg-6 text-right">
            <a class="btn btn-success" href="{{ route('customer.create') }}">Create New Customer Profile</a>
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
                <th scope="col">Customer Name</th>
                <th scope="col">Customer Type</th>
                <th scope="col">Registered By</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">City</th>
                <th scope="col" width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->customer_type }}</td>
                    <td>{{ $customer->registered_by }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">{{ $customer->customer_phone }}</span>
                            <button type="button" class="btn btn-link" onclick="window.location.href='tel:+88{{ $customer->customer_phone }}'">
                                <span class="bi bi-telephone"></span> Call
                            </button>
                        </div>
                    </td>
                    <td>{{ $customer->customer_email }}</td>
                    <td>{{ $customer->customer_city }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('customer.show', $customer->id) }}">Show</a>
                        <a class="btn btn-warning" href="{{ route('customer.edit', $customer->id) }}">Edit</a>                       
                        <a class="btn btn-danger" href="{{ route('customer.destroy', $customer->id) }}">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No customers available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {!! $customers->links() !!}
    </div>
</div>
<script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</script>

@endsection