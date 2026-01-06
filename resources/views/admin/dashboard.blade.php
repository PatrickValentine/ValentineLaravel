@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">

    <h2 class="text-center fw-bold text-dark mb-5 display-5">Admin Dashboard</h2>

    <div class="row g-4">

        {{-- Left Column --}}
        <div class="col-lg-8 d-grid gap-4">
            @if(auth()->user()->is_admin)
                {{-- User Management --}}
                <div class="card shadow-lg border-danger rounded-4">
                    <div class="card-header bg-danger text-white fw-bold rounded-top-4 d-flex align-items-center">
                        <i class="bi bi-people me-2 fs-4"></i> User Management
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.users') }}" class="btn btn-danger btn-lg w-100 mb-2 fw-semibold">
                            <i class="bi bi-people me-2"></i> Manage Users
                        </a>

                        <!-- Helper text -->
                        <p class="text-muted small text-center mt-2">
                            (To add user, first have user register at login screen)
                        </p>
                    </div>
                </div>

                {{-- System Settings --}}
                <div class="card shadow-lg border-primary rounded-4">
                    <div class="card-header bg-primary text-white fw-bold rounded-top-4 d-flex align-items-center">
                        <i class="bi bi-gear me-2 fs-4"></i> System Settings
                    </div>
                    <div class="card-body d-grid gap-3">
                        <a href="{{ route('admin.school-box-matrices') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-box me-2"></i> School Box Size Matrix
                        </a>
                        <a href="{{ route('admin.hospital-box-matrices') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-box me-2"></i> Hospital Box Size Matrix
                        </a>
                        <a href="{{ route('admin.sendgrid_mappings.school') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-truck me-2"></i> School Sendgrid Field Mappings
                        </a>
                        <a href="{{ route('admin.sendgrid_mappings.hospital') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-truck me-2"></i> Hospital Sendgrid Field Mappings
                        </a>
                        <a href="{{ route('admin.fedex_mappings.school_outgoing') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-truck me-2"></i> School Outgoing FedEx Field Mappings
                        </a>
                        <a href="{{ route('admin.fedex_mappings.school_return') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-arrow-return-left me-2"></i> School Return FedEx Field Mappings
                        </a>
                        <a href="{{ route('admin.fedex_mappings.hospital_outgoing') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="bi bi-hospital me-2"></i> Hospital Outgoing FedEx Field Mappings
                        </a>
                    </div>
                </div>
            @endif

            {{-- Organization Management --}}
            <div class="card shadow-lg border-success rounded-4">
                <div class="card-header bg-success text-white fw-bold rounded-top-4 d-flex align-items-center">
                    <i class="bi bi-building me-2 fs-4"></i> Organization Management
                </div>
                <div class="card-body d-grid gap-3">
                    <a href="{{ route('admin.schools') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-building me-2"></i> Manage Schools
                    </a>
                    <a href="{{ route('admin.hospitals') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-heart-pulse me-2"></i> Manage Hospitals
                    </a>
                    <a href="{{ route('admin.volunteers') }}" class="btn btn-outline-success btn-lg w-100">
                        <i class="bi bi-person-badge me-2"></i> Manage Volunteers
                    </a>
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div class="col-lg-4 d-grid gap-4">
            @if(auth()->user()->is_admin)
                {{-- Backup Management --}}
                <div class="card shadow-lg border-info rounded-4">
                    <div class="card-header bg-info text-white fw-bold rounded-top-4 d-flex align-items-center justify-content-between">
                        <div><i class="bi bi-cloud-arrow-down me-2 fs-4"></i> Backups</div>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('admin.backups') }}" class="btn btn-outline-info btn-lg w-100">
                            <i class="bi bi-folder2-open me-2"></i> Manage Backups
                        </a>
                    </div>
                </div>
            @endif

            {{-- Change Password --}}
            <div class="card shadow-lg border-warning rounded-4">
                <div class="card-header bg-warning text-dark fw-bold rounded-top-4 d-flex align-items-center">
                    <i class="bi bi-lock me-2 fs-4"></i> Change Password
                </div>
                <div class="card-body" style="background-color: #fff8e1;">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                            @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-semibold">
                            <i class="bi bi-shield-lock me-2"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Pause Period --}}
            <div class="card shadow-lg border-success rounded-4">
                <div class="card-header bg-success text-white fw-bold rounded-top-4 d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2 fs-4"></i> Pause Period
                </div>
                <div class="card-body" style="background-color: #e9f7ef;">
                    <form method="POST" action="{{ route('admin.pause.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="school_pause_date" class="form-label">School Pause Date</label>
                            <input type="date" name="school_pause_date" id="school_pause_date" class="form-control"
                                value="{{ old('school_pause_date', $pauseData['school_start'] ?? '') }}">
                            @error('school_pause_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hospital_pause_date" class="form-label">Hospital Pause Date</label>
                            <input type="date" name="hospital_pause_date" id="hospital_pause_date" class="form-control"
                                value="{{ old('hospital_pause_date', $pauseData['hospital_start'] ?? '') }}">
                            @error('hospital_pause_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="end_pause_date" class="form-label">End Pause Date</label>
                            <input type="date" name="end_pause_date" id="end_pause_date" class="form-control"
                                value="{{ old('end_pause_date', $pauseData['end_date'] ?? '') }}">
                            @error('end_pause_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            <i class="bi bi-check-circle me-2"></i> Update Pause Period
                        </button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

<style>
    .card-header {
        font-size: 1.1rem;
    }

    .btn-lg {
        border-radius: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .fw-semibold {
        font-weight: 600 !important;
    }
</style>
@endsection
