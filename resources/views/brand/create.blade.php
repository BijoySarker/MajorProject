@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Add New Brand</h2>
                <a class="btn btn-primary" href="{{ route('brand.index') }}">Back</a>
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

        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
        
            <div class="row mt-3">
                <div class="mb-3">
                    <div class="form-group">
                        <label for="name">Brand Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Brand Name" required>
                    </div>
                </div>
        
                <div class="mb-3">
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" aria-label="file example" id="image" name="image" required>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection