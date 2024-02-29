@extends('layout')

@section('title', 'General Settings Index')

@section('content')
    <div class="container">
        <h1 class="mb-4">General Settings Index</h1>

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('general_settings.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="system_name" class="form-label">System Name:</label>
                        <input type="text" name="system_name" id="system_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="system_logo" class="form-label">System Logo:</label>
                        <input type="file" name="system_logo" id="system_logo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="system_timezone" class="form-label">System Timezone:</label>
                        <input type="text" name="system_timezone" id="system_timezone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_login_page_background" class="form-label">Admin Login Page Background:</label>
                        <input type="text" name="admin_login_page_background" id="admin_login_page_background" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="system_address" class="form-label">System Address:</label>
                        <input type="text" name="system_address" id="system_address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="system_email" class="form-label">System Email:</label>
                        <input type="email" name="system_email" id="system_email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="system_phone" class="form-label">System Phone:</label>
                        <input type="tel" name="system_phone" id="system_phone" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h3>General Settings List</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>System Name</th>
                            <th>System Logo</th>
                            <th>System Timezone</th>
                            <th>Admin Login Page Background</th>
                            <th>System Address</th>
                            <th>System Email</th>
                            <th>System Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($generalSettings as $setting)
                            <tr>
                                <td>{{ $setting->system_name }}</td>
                                <td>{{ $setting->system_logo }}</td>
                                <td>{{ $setting->system_timezone }}</td>
                                <td>{{ $setting->admin_login_page_background }}</td>
                                <td>{{ $setting->system_address }}</td>
                                <td>{{ $setting->system_email }}</td>
                                <td>{{ $setting->system_phone }}</td>
                                <td>
                                    {{-- <a href="{{ route('general_settings.edit', $setting->id) }}" class="btn btn-primary">Edit</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
