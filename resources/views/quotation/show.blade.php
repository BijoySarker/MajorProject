@extends('layout')

@section('title', 'Quotation Details')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h2>Quotation Details</h2>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Quotation Information</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Quotation Number:</strong> {{ $quotation->quotation_number }}</p>
                        <p><strong>Quotation Type:</strong> {{ $quotation->quotation_type === 0 ? 'Dealer' : 'Corporate' }}</p>
                        <p><strong>Company Name:</strong> {{ $quotation->company_name }}</p>
                        <p><strong>Company Address:</strong> {{ $quotation->company_address }}</p>
                        <p><strong>Company Persons:</strong> {{ $quotation->company_persons }}</p>
                        <p><strong>Quotation Subject:</strong> {{ $quotation->quotation_subject }}</p>
                        <p><strong>Attention:</strong> {{ $quotation->attention_quot }}</p>
                        <p><strong>Dear Sir:</strong> {{ $quotation->dear_sir }}</p>
                        <p><strong>Quotation Body:</strong> {{ $quotation->quotation_body }}</p>
                    </div>
                </div>

                <!-- Display Selected Products -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Selected Products</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->getProductIdsAttribute() as $id)
                                    @php
                                        $product = \App\Models\Product::find($id);
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ $product->pivot->unit_price }}</td>
                                        <td>{{ $product->pivot->quantity * $product->pivot->unit_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Total:</td>
                                    <td>{{ $quotation->total_price }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Terms and Conditions</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $quotation->terms_and_condition }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection