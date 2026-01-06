@extends('layouts.app')

@section('title', 'User Management')

@section('content')
@if(session('success'))
    <div class="alert alert-success text-center mt-3">
        {!! session('success') !!}
    </div>
@endif
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-danger text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill display-6 me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">User Management</h4>
                        <small class="opacity-75">Manage your application users and permissions</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-danger me-3">
                        <i class="bi bi-person-check me-1"></i>{{ $users->where('is_admin', true)->count() }} Admins
                    </span>
                    <span class="badge bg-light text-danger">
                        <i class="bi bi-person me-1"></i>{{ $users->where('is_admin', false)->count() }} Users
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-danger">
                            <tr>
                                <th scope="col" class="text-center" style="width: 60px;">
                                    <i class="bi bi-hash"></i>
                                </th>
                                <th scope="col">
                                    <i class="bi bi-person-circle me-1"></i>User Information
                                </th>
                                <th scope="col">
                                    <i class="bi bi-envelope me-1"></i>Email Address
                                </th>
                                <th scope="col" class="text-center">
                                    <i class="bi bi-shield-check me-1"></i>Role
                                </th>
                                <th scope="col" class="text-center">
                                    <i class="bi bi-calendar me-1"></i>Joined
                                </th>
                                <th scope="col" class="text-center" style="width: 200px;">
                                    <i class="bi bi-gear me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $user->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person-fill text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                                <small class="text-muted">User ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-envelope text-muted me-2"></i>
                                            <span class="fw-semibold">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($user->is_admin)
                                            <span class="badge bg-danger fs-6 px-3 py-2">
                                                <i class="bi bi-shield-check me-1"></i>Admin
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                                <i class="bi bi-person me-1"></i>User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                            <small class="text-success">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm" title="Edit User">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="{{ route('admin.users.password.edit', $user) }}" class="btn btn-outline-warning btn-sm" title="Change Password">
                                                <i class="bi bi-key"></i>
                                            </a>

                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete User">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i>
                            Total Users: {{ $users->count() }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Administrators: {{ $users->where('is_admin', true)->count() }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i>
                            Regular Users: {{ $users->where('is_admin', false)->count() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}
.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}
.btn-group .btn {
    border-radius: 0.375rem !important;
    margin: 0 2px;
}
.avatar {
    transition: transform 0.2s;
}
.avatar:hover {
    transform: scale(1.1);
}
</style>
@endsection