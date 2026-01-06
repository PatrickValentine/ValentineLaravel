@extends('layouts.app')

@section('title', 'Add New School')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.schools.store') }}" method="POST">
            @csrf
            <!-- School Information Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <i class="bi bi-building display-6 me-2"></i>
                    <span class="fs-5 fw-bold">School Information</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="organization_name" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i> Organization Name
                            </label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                   id="organization_name" name="organization_name" value="{{ old('organization_name') }}" 
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+" placeholder="e.g., Lincoln Elementary School">
                            @error('organization_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i> Contact Person Name
                            </label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" 
                                   id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name') }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+" placeholder="e.g., John Smith">
                            @error('contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="col-md-6">
                            <label for="contact_title" class="form-label fw-semibold">
                                <i class="bi bi-award me-1"></i> Title of Contact Person
                            </label>
                            <input type="text" class="form-control @error('contact_title') is-invalid @enderror" 
                                   id="contact_title" name="contact_title" value="{{ old('contact_title') }}" 
                                   maxlength="50" placeholder="e.g., Principal, Coordinator">
                            @error('contact_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="how_to_address" class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-1"></i> How to Address You
                            </label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" 
                                   id="how_to_address" name="how_to_address" value="{{ old('how_to_address') }}" 
                                   placeholder="e.g., Mr. Smith, Ms. Jones">
                            @error('how_to_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="contact@school.edu">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1"></i> Phone Number
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" maxlength="10" pattern="[0-9]{10}" placeholder="5551234567">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i> Street Address
                            </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                   id="street" name="street" value="{{ old('street') }}" 
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+" placeholder="123 Main Street">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>                    

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="city" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i> City
                            </label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}" maxlength="35" pattern="[A-Za-z0-9 .-]+" placeholder="Anytown">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                <i class="bi bi-map me-1"></i> State
                            </label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                   id="state" name="state" value="{{ old('state') }}" pattern="[A-Za-z]{2}" placeholder="CA" maxlength="2">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="zip" class="form-label fw-semibold">
                                <i class="bi bi-pin-map me-1"></i> ZIP Code
                            </label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                   id="zip" name="zip" value="{{ old('zip') }}" placeholder="12345" maxlength="5">
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quantities & Volunteer Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <i class="bi bi-box-seam display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Quantities & Volunteer</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="envelope_quantity" class="form-label fw-semibold">
                                <i class="bi bi-envelope-paper me-1"></i> Envelope Quantity
                            </label>
                            <input type="number" class="form-control @error('envelope_quantity') is-invalid @enderror" 
                                   id="envelope_quantity" name="envelope_quantity" value="{{ old('envelope_quantity') }}" min="0">
                            @error('envelope_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="instructions_cards" class="form-label fw-semibold">
                                <i class="bi bi-card-text me-1"></i> Instructions Cards
                            </label>
                            <input type="number" class="form-control @error('instructions_cards') is-invalid @enderror" 
                                   id="instructions_cards" name="instructions_cards" value="{{ old('instructions_cards') }}" min="0">
                            @error('instructions_cards')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="standing_order" class="form-label fw-semibold">
                                <i class="bi bi-check-circle me-1"></i> Standing Order
                            </label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1" {{ old('standing_order', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="standing_order">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="qty_sent_last_year" class="form-label fw-semibold">
                                <i class="bi bi-send-check me-1"></i> Qty Sent Last Year
                            </label>
                            <input type="number" class="form-control @error('qty_sent_last_year') is-invalid @enderror" 
                                   id="qty_sent_last_year" name="qty_sent_last_year" value="{{ old('qty_sent_last_year') }}" min="0">
                            @error('qty_sent_last_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="qty_received_last_year" class="form-label fw-semibold">
                                <i class="bi bi-inbox-arrow-down me-1"></i> Qty Received Last Year
                            </label>
                            <input type="number" class="form-control @error('qty_received_last_year') is-invalid @enderror" 
                                   id="qty_received_last_year" name="qty_received_last_year" value="{{ old('qty_received_last_year') }}" min="0">
                            @error('qty_received_last_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="volunteer_id" class="form-label fw-semibold">
                                <i class="bi bi-people me-1"></i> Assign Volunteer
                            </label>
                            <select class="form-select @error('volunteer_id') is-invalid @enderror" id="volunteer_id" name="volunteer_id">
                                <option value="">— Select Volunteer —</option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}" {{ old('volunteer_id') == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }} ({{ $volunteer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('volunteer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes / Comments Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-secondary text-white py-3">
                    <i class="bi bi-chat-left-text display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Notes</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="public_notes" class="form-label fw-semibold">
                            <i class="bi bi-question-circle me-1"></i> Notes from School
                        </label>
                        <textarea class="form-control @error('public_notes') is-invalid @enderror" 
                                  id="public_notes" name="public_notes" rows="3">{{ old('public_notes') }}</textarea>
                        @error('public_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="internal_notes" class="form-label fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> Internal Notes
                        </label>
                        <textarea class="form-control @error('internal_notes') is-invalid @enderror" 
                                  id="internal_notes" name="internal_notes" rows="3">{{ old('internal_notes') }}</textarea>
                        @error('internal_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.schools') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Create School
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
