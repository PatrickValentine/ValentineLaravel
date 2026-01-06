@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="row justify-content-center align-items-center min-vh-50">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center text-danger fw-bold">Edit User</h2>
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_admin" class="form-label">Admin</label>
                        <select name="is_admin" id="is_admin" class="form-select">
                            <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Update User</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-link w-100 mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection