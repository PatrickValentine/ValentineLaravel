@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center align-items-center min-vh-50">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center text-danger fw-bold">Register</h2>
                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Register</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-danger">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection