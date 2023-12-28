@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between align-items-center">
                <h2>Add New Category</h2>
                <a class="btn btn-primary" href="{{ route('categories.index') }}">Back</a>
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

        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                    
            <div class="form-group">
                <label for="category_id">Parent Category:</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Select Existing Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    <option value="new">Add New Parent Category</option>
                </select>
            </div>
        
            <div class="form-group" id="newCategoryInput" style="display: none;">
                <label for="new_category_name">New Parent Category Name:</label>
                <input type="text" class="form-control" name="new_category_name">
            </div>
        
            <div class="form-group">
                <label for="name">Child Category Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">Upload Image:</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Child Category</button>
        </form>
        
        <script>
            document.getElementById('category_id').addEventListener('change', function() {
                var newCategoryInput = document.getElementById('newCategoryInput');
                newCategoryInput.style.display = this.value === 'new' ? 'block' : 'none';
            });
        </script>
    </div>
@endsection