@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

<div class="row justify-content-center align-items-center min-vh-50">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center text-danger fw-bold">Change Password for {{ $user->name }}</h2>
                <form action="{{ route('admin.users.password.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="8">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-key"></i> Update Password
                    </button>
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
