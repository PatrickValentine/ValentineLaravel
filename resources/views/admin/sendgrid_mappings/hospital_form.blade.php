@extends('layouts.app')

@section('title', isset($sendgridMapping) ? 'Edit Mapping' : 'Add Mapping')

@section('content')
<div class="container">
    <h3>{{ isset($sendgridMapping) ? 'Edit Mapping' : 'Add New Mapping' }}</h3>

    <form method="POST" 
          action="{{ isset($sendgridMapping) 
              ? route('admin.sendgrid_mappings.hospital.update', $sendgridMapping) 
              : route('admin.sendgrid_mappings.hospital.store') }}">
        @csrf
        @if(isset($sendgridMapping)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Sendgrid Field</label>
            <input type="text" name="sendgrid_field" class="form-control" 
                   value="{{ old('sendgrid_field', $sendgridMapping->sendgrid_field ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Field</label>
            <select name="our_field" class="form-select">
                <option value="">— None —</option>
            
                <optgroup label="Hospitals Table">
                    @foreach($allFields['hospitals'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $sendgridMapping->our_field ?? '') == $field ? 'selected' : '' }}>
                            {{ $field }}
                        </option>
                    @endforeach
                </optgroup>
            
                <optgroup label="Box Size Matrices Table">
                    @foreach($allFields['hospital_box_size_matrices'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $sendgridMapping->our_field ?? '') == $field ? 'selected' : '' }}>
                            {{ $field }}
                        </option>
                    @endforeach
                </optgroup>

                <optgroup label="Custom">
                    @foreach($allFields['custom'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $sendgridMapping->our_field ?? '') == $field ? 'selected' : '' }}>
                            {{ $field }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
            <small class="text-muted">Leave empty if using common value</small>
        </div>        

        {{-- <div class="mb-3">
            <label class="form-label">Our Field</label>
            <input type="text" name="our_field" class="form-control" 
                   value="{{ old('our_field', $sendgridMapping->our_field ?? '') }}">
            <small class="text-muted">Leave empty if using common value</small>
        </div> --}}

        <div class="mb-3">
            <label class="form-label">Common Value</label>
            <input type="text" name="common_value" class="form-control" 
                   value="{{ old('common_value', $sendgridMapping->common_value ?? '') }}">
            <small class="text-muted">E.g. "US" for CountryCode</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" 
                   value="{{ old('description', $sendgridMapping->description ?? '') }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Save
        </button>
        <a href="{{ route('admin.sendgrid_mappings.hospital') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
