@extends('layouts.app')

@section('title', 'Add New Hospital')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.hospitals.store') }}" method="POST">
            @csrf

            <!-- Hospital Information Card (including Address) -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <i class="bi bi-heart-pulse display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Hospital Information</span>
                </div>
                <div class="card-body">

                    <!-- Organization & Contact -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="organization_name" class="form-label fw-semibold">
                                <i class="bi bi-heart-pulse me-1"></i>Organization Name
                            </label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                   id="organization_name" name="organization_name" value="{{ old('organization_name') }}" 
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+" placeholder="e.g., Memorial Hospital">
                            @error('organization_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="organization_type" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>Organization Type
                            </label>
                            <input type="text" class="form-control @error('organization_type') is-invalid @enderror" 
                                   id="organization_type" name="organization_type" value="{{ old('organization_type') }}" 
                                   placeholder="Hospital, Clinic">
                            @error('organization_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Contact Person Name
                            </label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" 
                                   id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name') }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+" placeholder="Dr. John Smith">
                            @error('contact_person_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="how_to_address" class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>How to Address You
                            </label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" 
                                   id="how_to_address" name="how_to_address" value="{{ old('how_to_address') }}" 
                                   placeholder="Dr. Smith, Ms. Jones">
                            @error('how_to_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="contact@hospital.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i>Phone Number
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   maxlength="10" pattern="[0-9]{10}" placeholder="5551234567">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Street Address
                            </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                   id="street" name="street" value="{{ old('street') }}" 
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+" placeholder="123 Medical Center Drive">
                            @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="city" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>City
                            </label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+" placeholder="City">
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="county" class="form-label fw-semibold">
                                <i class="bi bi-geo me-1"></i> County
                            </label>
                            <input type="text" class="form-control @error('county') is-invalid @enderror" 
                                   id="county" name="county" value="{{ old('county') }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+" placeholder="e.g., Mont">
                            @error('county')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="state" class="form-label fw-semibold">
                                <i class="bi bi-map me-1"></i>State
                            </label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state') }}" 
                                   pattern="[A-Za-z]{2}" placeholder="CA" maxlength="2">
                            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label for="zip" class="form-label fw-semibold">
                                <i class="bi bi-pin-map me-1"></i>ZIP Code
                            </label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                   id="zip" name="zip" value="{{ old('zip') }}" placeholder="12345" maxlength="5">
                            @error('zip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Cards / Staff -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <i class="bi bi-card-checklist display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Cards & Staff</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="valentine_card_count" class="form-label fw-semibold">
                                <i class="bi bi-heart me-1"></i>Valentine Card Count
                            </label>
                            <input type="number" class="form-control @error('valentine_card_count') is-invalid @enderror" 
                                   id="valentine_card_count" name="valentine_card_count" value="{{ old('valentine_card_count') }}" min="0">
                            @error('valentine_card_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="extra_staff_cards" class="form-label fw-semibold">
                                <i class="bi bi-people me-1"></i>Extra Staff Cards
                            </label>
                            <input type="number" class="form-control @error('extra_staff_cards') is-invalid @enderror" 
                                   id="extra_staff_cards" name="extra_staff_cards" value="{{ old('extra_staff_cards') }}" min="0">
                            @error('extra_staff_cards')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1" {{ old('standing_order', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="standing_order">
                            <i class="bi bi-check-circle me-1"></i>Standing Order
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notes / Comments -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-secondary text-white py-3">
                    <i class="bi bi-chat-left-text display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Notes</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="public_notes" class="form-label fw-semibold">
                            <i class="bi bi-question-circle me-1"></i>Notes from Hosp/Organization
                        </label>
                        <textarea class="form-control @error('public_notes') is-invalid @enderror" 
                                  id="public_notes" name="public_notes" rows="3">{{ old('public_notes') }}</textarea>
                        @error('public_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="internal_notes" class="form-label fw-semibold">
                            <i class="bi bi-person-plus me-1"></i>Internal Notes
                        </label>
                        <textarea class="form-control @error('internal_notes') is-invalid @enderror" 
                                  id="internal_notes" name="internal_notes" rows="3">{{ old('internal_notes') }}</textarea>
                        @error('internal_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.hospitals') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create Hospital
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll("input[type=text]").forEach(el => {
        el.addEventListener("input", function() {
            this.value = this.value.replace(/[^A-Za-z0-9 .-]/g, "");
        });
    });

    document.getElementById("phone").addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, "").slice(0, 10);
    });
</script>
@endsection
