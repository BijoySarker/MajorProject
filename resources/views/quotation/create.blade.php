@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Quotation</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('quotation.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="quotation_number">Quotation Number</label>
                                <input type="text" class="form-control" id="quotation_number" name="quotation_number" required>
                            </div>

                            <div class="form-group">
                                <label for="product_id">Product ID</label>
                                <input type="text" class="form-control" id="product_id" name="product_id" required>
                            </div>

                            <div class="form-group">
                                <label for="terms_and_condition">Terms and Conditions</label>
                                <textarea id="terms_and_condition" name="terms_and_condition"></textarea>
                            </div>

                            <!-- Add other form fields based on your Quotation model -->

                            <button type="submit" class="btn btn-primary">
                                Create Quotation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        CKEDITOR.replace('terms_and_condition', {
          placeholder: 'Enter your text here...',
        });
      </script>
@endsection