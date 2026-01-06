@extends('layouts.app')

@section('title', 'Edit Volunteer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            <!-- Card wrapper -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <i class="bi bi-pencil-square fs-4 me-2"></i>
                    <h4 class="mb-0">Edit Volunteer</h4>
                </div>
                <div class="card-body p-4">

                    <!-- Form -->
                    <form action="{{ route('admin.volunteers.update', $volunteer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name & Email -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $volunteer->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $volunteer->email }}" required>
                            </div>
                        </div>

                        <!-- Phone & Address -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $volunteer->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $volunteer->address }}">
                            </div>
                        </div>

                        <!-- Role & School Credit -->
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role</label>
                                <input type="text" name="role" class="form-control" value="{{ $volunteer->role }}">
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="needs_school_credit" value="1" id="schoolCredit"
                                        {{ $volunteer->needs_school_credit ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="schoolCredit">
                                        Needs School Credit
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Qualifications & Notes -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description of Qualifications</label>
                            <textarea name="qualifications" rows="3" class="form-control">{{ $volunteer->qualifications }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes from School</label>
                            <textarea name="notes" rows="2" class="form-control">{{ $volunteer->notes }}</textarea>
                        </div>

                        <!-- LinkedIn & Resume -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">LinkedIn URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                    <input type="url" name="linkedin_url" class="form-control" value="{{ $volunteer->linkedin_url }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Resume URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <input type="url" name="resume_url" class="form-control" value="{{ $volunteer->resume_url }}">
                                </div>
                            </div>
                        </div>

                        <!-- Classification -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Classification</label>
                            <input type="text" name="classification" class="form-control" value="{{ $volunteer->classification }}">
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.volunteers') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-check-circle me-1"></i> Update Volunteer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- End Card -->

        </div>
    </div>
</div>
@endsection
