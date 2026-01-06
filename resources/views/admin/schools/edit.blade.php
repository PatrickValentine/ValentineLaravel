@extends('layouts.app')

@section('title', 'Edit School')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('admin.schools.update', $school) }}" method="POST">
            @csrf
            @method('PUT')

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
                                <i class="bi bi-building me-1 text-danger"></i> Organization Name
                            </label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror"
                                   id="organization_name" name="organization_name"
                                   value="{{ old('organization_name', $school->organization_name) }}"
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+">
                            @error('organization_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1 text-primary"></i> Contact Person Name
                            </label>
                            <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror"
                                   id="contact_person_name" name="contact_person_name"
                                   value="{{ old('contact_person_name', $school->contact_person_name) }}"
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('contact_person_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_title" class="form-label fw-semibold">
                                <i class="bi bi-award me-1"></i> Title of Contact Person
                            </label>
                            <input type="text" class="form-control @error('contact_title') is-invalid @enderror" 
                                   id="contact_title" name="contact_title" 
                                   value="{{ old('contact_title', $school->contact_title) }}" 
                                   maxlength="50" placeholder="e.g., Principal, Coordinator">
                            @error('contact_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="how_to_address" class="form-label fw-semibold">
                                <i class="bi bi-chat-square-dots me-1 text-secondary"></i> How to Address You
                            </label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror"
                                   id="how_to_address" name="how_to_address"
                                   value="{{ old('how_to_address', $school->how_to_address) }}"
                                   placeholder="e.g., Mr. Smith, Ms. Jones">
                            @error('how_to_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1 text-warning"></i> Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $school->email) }}"
                                   placeholder="contact@school.edu">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-1 text-success"></i> Phone Number
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $school->phone) }}"
                                   maxlength="10" pattern="[0-9]{10}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="street" class="form-label fw-semibold">
                                <i class="bi bi-signpost-2 me-1 text-info"></i> Street Address
                            </label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror"
                                   id="street" name="street" value="{{ old('street', $school->street) }}"
                                   maxlength="30" pattern="[A-Za-z0-9 .-]+">
                            @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="city" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1 text-primary"></i> City
                            </label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city', $school->city) }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="county" class="form-label fw-semibold">
                                <i class="bi bi-geo me-1"></i> County
                            </label>
                            <input type="text" class="form-control @error('county') is-invalid @enderror"
                                   id="county" name="county" value="{{ old('county', $school->county) }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('county') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="state" class="form-label fw-semibold">
                                <i class="bi bi-map me-1 text-secondary"></i> State
                            </label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                   id="state" name="state" value="{{ old('state', $school->state) }}" 
                                   pattern="[A-Za-z]{2}" maxlength="2">
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="zip" class="form-label fw-semibold">
                                <i class="bi bi-mailbox me-1 text-danger"></i> ZIP Code
                            </label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                   id="zip" name="zip" value="{{ old('zip', $school->zip) }}" maxlength="5">
                            @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                <i class="bi bi-envelope-paper me-1 text-warning"></i> Envelope Quantity
                            </label>
                            <input type="number" class="form-control @error('envelope_quantity') is-invalid @enderror"
                                   id="envelope_quantity" name="envelope_quantity"
                                   value="{{ old('envelope_quantity', $school->envelope_quantity) }}" min="0">
                            @error('envelope_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="instructions_cards" class="form-label fw-semibold">
                                <i class="bi bi-card-text me-1 text-info"></i> Instructions Cards
                            </label>
                            <input type="number" class="form-control @error('instructions_cards') is-invalid @enderror"
                                   id="instructions_cards" name="instructions_cards"
                                   value="{{ old('instructions_cards', $school->instructions_cards) }}" min="0">
                            @error('instructions_cards') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="standing_order" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-1 text-success"></i> Standing Order
                            </label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" id="standing_order" name="standing_order" value="1"
                                       {{ old('standing_order', $school->standing_order) ? 'checked' : '' }}>
                                <label class="form-check-label" for="standing_order">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="qty_sent_last_year" class="form-label fw-semibold">
                                <i class="bi bi-send-check me-1 text-primary"></i> Qty Sent Last Year
                            </label>
                            <input type="number" class="form-control @error('qty_sent_last_year') is-invalid @enderror"
                                   id="qty_sent_last_year" name="qty_sent_last_year"
                                   value="{{ old('qty_sent_last_year', $school->qty_sent_last_year) }}" min="0">
                            @error('qty_sent_last_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="qty_received_last_year" class="form-label fw-semibold">
                                <i class="bi bi-download me-1 text-secondary"></i> Qty Received Last Year
                            </label>
                            <input type="number" class="form-control @error('qty_received_last_year') is-invalid @enderror"
                                   id="qty_received_last_year" name="qty_received_last_year"
                                   value="{{ old('qty_received_last_year', $school->qty_received_last_year) }}" min="0">
                            @error('qty_received_last_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="volunteer_id" class="form-label fw-semibold">
                                <i class="bi bi-people me-1 text-danger"></i> Assign Volunteer
                            </label>
                            <select class="form-select @error('volunteer_id') is-invalid @enderror" id="volunteer_id" name="volunteer_id">
                                <option value="">— Select Volunteer —</option>
                                @foreach($volunteers as $volunteer)
                                    <option value="{{ $volunteer->id }}"
                                        {{ old('volunteer_id', $school->volunteer_id) == $volunteer->id ? 'selected' : '' }}>
                                        {{ $volunteer->name }} ({{ $volunteer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('volunteer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <i class="bi bi-question-circle me-1 text-primary"></i> Notes from School
                        </label>
                        <textarea class="form-control @error('public_notes') is-invalid @enderror" id="public_notes" name="public_notes" rows="3">{{ old('public_notes', $school->public_notes) }}</textarea>
                        @error('public_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="internal_notes" class="form-label fw-semibold">
                            <i class="bi bi-megaphone me-1 text-warning"></i> Internal Notes
                        </label>
                        <textarea class="form-control @error('internal_notes') is-invalid @enderror" id="internal_notes" name="internal_notes" rows="3">{{ old('internal_notes', $school->internal_notes) }}</textarea>
                        @error('internal_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Editable Last Updated -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <i class="bi bi-info-circle display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Others</span>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Last Updated Date -->
                        <div class="col-md-3">
                            <label for="updated_at" class="form-label fw-semibold">
                                <i class="bi bi-calendar-date me-1 text-info"></i> Last Updated Date
                            </label>
                            <input type="datetime-local"
                                id="updated_at"
                                name="updated_at"
                                class="form-control @error('updated_at') is-invalid @enderror"
                                value="{{ old('updated_at', $school->updated_at ? $school->updated_at->format('Y-m-d\TH:i') : '') }}">
                            @error('updated_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">By default this is auto-managed, but you can override it manually.</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold" for="status_flag">
                                <i class="bi bi-flag me-1"></i> New/Updated
                            </label>
                            <select name="update_status" id="update_status"
                                    class="form-select @error('update_status') is-invalid @enderror">
                                <option value="0" {{ old('update_status', $school->update_status ?? '') == 0 ? 'selected' : '' }}>New</option>
                                <option value="1" {{ old('update_status', $school->update_status ?? '') == 1 ? 'selected' : '' }}>Updated</option>
                            </select>
                            @error('update_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Choose whether this record is new or recently updated.</small>
                        </div>

                        <!-- Prefilled Edit Link -->
                        <div class="col-md-6">
                            <label for="editLinkInput" class="form-label fw-semibold">
                                <i class="bi bi-link-45deg me-1 text-success"></i> Prefilled Edit Link
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $school->prefilled_link }}" readonly id="editLinkInput">
                                <button type="button" class="btn btn-outline-success" onclick="copyToClipboard()">Copy</button>
                            </div>
                            <small class="text-muted">This link allows editing the school form directly with prefilled values.</small>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Prefilled Edit Link -->
            <!-- <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <i class="bi bi-link-45deg display-6 me-2"></i>
                    <span class="fs-5 fw-bold">Prefilled Edit Link</span>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $school->prefilled_link }}" readonly id="editLinkInput">
                        <button type="button" class="btn btn-outline-success" onclick="copyToClipboard()">Copy</button>
                    </div>
                    <small class="text-muted">This link allows editing the school form directly with prefilled values.</small>
                </div>
            </div> -->

            <script>
                
            </script>

            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('admin.schools') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-danger btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Update School
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

    function copyToClipboard() {
        const input = document.getElementById('editLinkInput');
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand('copy');
        // alert('Link copied to clipboard!');
    }
</script>
@endsection
