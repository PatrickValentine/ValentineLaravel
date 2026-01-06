@extends('layouts.app')

@section('title', isset($fedexMapping) ? 'Edit Mapping' : 'Add Mapping')

@section('content')
<div class="container">
    <h3>{{ isset($fedexMapping) ? 'Edit Mapping' : 'Add New Mapping' }}</h3>

    <form method="POST" 
          action="{{ isset($fedexMapping) 
              ? route('admin.fedex_mappings.hospital_outgoing.update', $fedexMapping) 
              : route('admin.fedex_mappings.hospital_outgoing.store') }}">
        @csrf
        @if(isset($fedexMapping)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">FedEx Field</label>
            <input type="text" name="fedex_field" class="form-control" 
                   value="{{ old('fedex_field', $fedexMapping->fedex_field ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Our Field</label>
            <select name="our_field" class="form-select">
                <option value="">— None —</option>
            
                <optgroup label="Hospitals Table">
                    @foreach($allFields['hospitals'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $fedexMapping->our_field ?? '') == $field ? 'selected' : '' }}>
                            {{ $field }}
                        </option>
                    @endforeach
                </optgroup>
            
                <optgroup label="Box Size Matrices Table">
                    @foreach($allFields['hospital_box_size_matrices'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $fedexMapping->our_field ?? '') == $field ? 'selected' : '' }}>
                            {{ $field }}
                        </option>
                    @endforeach
                </optgroup>

                <optgroup label="Custom">
                    @foreach($allFields['custom'] as $field)
                        <option value="{{ $field }}"
                            {{ old('our_field', $fedexMapping->our_field ?? '') == $field ? 'selected' : '' }}>
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
                   value="{{ old('our_field', $fedexMapping->our_field ?? '') }}">
            <small class="text-muted">Leave empty if using common value</small>
        </div> --}}

        <div class="mb-3">
            <label class="form-label">Common Value</label>
            <input type="text" name="common_value" class="form-control" 
                   value="{{ old('common_value', $fedexMapping->common_value ?? '') }}">
            <small class="text-muted">E.g. "US" for CountryCode</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" 
                   value="{{ old('description', $fedexMapping->description ?? '') }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Save
        </button>
        <a href="{{ route('admin.fedex_mappings.hospital_outgoing') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
