@extends('layouts.app')

@section('title', 'Update For Hospitals/Care Facilities')

@section('content')
<style>
    body {
        background-color: #f9f0f4; /* soft pink background */
    }
    .form-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    .form-header {
        background-color: #a61c4c; /* dark pink accent bar */
        height: 8px;
    }
    .form-body {
        padding: 24px;
    }
    .form-title {
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-desc {
        font-size: 0.95rem;
        color: #444;
        margin-bottom: 1rem;
    }
    .form-section {
        border-top: 1px solid #eee;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
</style>

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Logo -->
            <div class="text-center mb-4">
                <h1 class="fw-bold text-danger" style="font-family: 'Pacifico', cursive; font-size: 3rem;">
                    Valentines By Kids
                </h1>
            </div>

            <!-- Card -->
            <div class="form-card">
                <!-- Accent bar -->
                <div class="form-header"></div>

                <!-- Body -->
                <div class="form-body">
                    <div class="form-title">Hospital and Facility Update Form</div>
                    <div class="form-desc">
                        @if( $isHospitalPaused )
                            <p><strong>You may update the information below. 
                                Remember to click “Submit” at the end. 
                                Thank you for participating with Valentines By Kids!</strong></p>
                        @else
                            <p><strong>You may update the information below. Remember to click “Submit” at the end. 
                                Thank you for participating with Valentines By Kids!</strong></p>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {!! session('success') !!}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('hospital.update', $hospital->token) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Question 1 -->
                        {{-- <div class="form-section">
                            <label class="form-label">
                                Will you participate to create wonderful Valentine’s Day cards? <span class="text-danger">*</span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="yes" id="yes" required>
                                <label class="form-check-label" for="yes">YES! Count us in!</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="no" id="no">
                                <label class="form-check-label" for="no">No, we will not. Please remove our name from your list.</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="participate" value="other" id="other">
                                <label class="form-check-label" for="other">Other</label>
                            </div>
                        </div> --}}

                        <!-- Question 2 -->
                        <div class="form-section">
                            <label for="organization_name" class="form-label">Name of Organization <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                id="organization_name" name="organization_name" value="{{ old('organization_name', $hospital->organization_name) }}" 
                                maxlength="30" pattern="[A-Za-z0-9 .-]+">
                            @error('organization_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="organization_type" class="form-label">Type of Organization <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization_type') is-invalid @enderror" 
                                id="organization_type" name="organization_type" value="{{ old('organization_type', $hospital->organization_type) }}">
                            @error('organization_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact Person -->
                        <div class="form-section">
                            <label for="contact_person_name" class="form-label">Contact Person's Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                id="contact_person_name" name="contact_person_name" value="{{ old('contact_person_name', $hospital->contact_person_name) }}" 
                                maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-section">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $hospital->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="how_to_address" class="form-label">How to address you (like "Ms. Anderson") <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('how_to_address') is-invalid @enderror" 
                                id="how_to_address" name="how_to_address" value="{{ old('how_to_address', $hospital->how_to_address) }}">
                            @error('how_to_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantities -->
                        <div class="form-section">
                            <label for="valentine_card_count" class="form-label">Number of Valentine's Day Cards Desired for your patients/clients?</label>
                            <input type="number" class="form-control @error('valentine_card_count') is-invalid @enderror" 
                                id="valentine_card_count" name="valentine_card_count" value="{{ old('valentine_card_count', $hospital->valentine_card_count) }}">
                            @error('valentine_card_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="extra_staff_cards" class="form-label">If we have enough cards, how many extra cards would you like for your wonderful staff?</label>
                            <input type="number" class="form-control @error('extra_staff_cards') is-invalid @enderror" 
                                id="extra_staff_cards" name="extra_staff_cards" value="{{ old('extra_staff_cards', $hospital->extra_staff_cards) }}">
                            @error('extra_staff_cards')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Information -->
                        <div class="form-section">
                            <label for="street" class="form-label">Street address for delivery to you (no city, state, zip here) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                id="street" name="street" value="{{ old('street', $hospital->street) }}" 
                                maxlength="30" pattern="[A-Za-z0-9 .-]+">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                id="city" name="city" value="{{ old('city', $hospital->city) }}" 
                                maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="county" class="form-label">County</label>
                            <input type="text" class="form-control @error('county') is-invalid @enderror"
                                   id="county" name="county" value="{{ old('county', $hospital->county) }}" 
                                   maxlength="35" pattern="[A-Za-z0-9 .-]+">
                            @error('county')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="state" class="form-label">State/District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                id="state" name="state" value="{{ old('state', $hospital->state) }}" 
                                pattern="[A-Za-z]{2}" maxlength="2">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-section">
                            <label for="zip" class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                id="zip" name="zip" value="{{ old('zip', $hospital->zip) }}" maxlength="5">
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-section">
                            <label for="phone" class="form-label">Phone (Fedex requires in case they have an issue - enter 10 digits only - no dashes, no hyphens, spaces, or parentheses): <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"    
                                id="phone" name="phone" value="{{ old('phone', $hospital->phone) }}" 
                                maxlength="10" pattern="[0-9]{10}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status and Additional Information -->
                        <div class="form-section">
                            <label for="standing_order" class="form-label">Do you want to make this a standing order (we send you the same amount each year) so you don't need to worry about remembering? (Easier for us and for you!)</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                    id="standing_order" name="standing_order" value="1" {{ old('standing_order', $hospital->standing_order) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Text Areas -->
                        <div class="form-section">
                            <label for="public_notes" class="form-label">Any other questions or comments?</label>
                            <textarea class="form-control @error('public_notes') is-invalid @enderror" 
                                    id="public_notes" name="public_notes" rows="3">{{ old('public_notes', $hospital->public_notes) }}</textarea>
                            @error('public_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="form-section">
                            <label for="introducer" class="form-label">How did you hear about Valentine's By Kids?</label>
                            <textarea class="form-control @error('introducer') is-invalid @enderror" 
                                    id="introducer" name="introducer" rows="3">{{ old('introducer', $hospital->introducer) }}</textarea>
                            @error('introducer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <!-- Submit -->
                        <div class="form-section d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        
                            <!-- Reset button -->
                            <button type="reset" class="btn btn-outline-secondary">Clear Form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
