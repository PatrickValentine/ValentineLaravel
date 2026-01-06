@extends('layouts.app')

@section('title', 'Edit Hospital Box Size Matrix')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0 fw-bold">Edit Hospital Box Size Matrix</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.hospital-box-matrices.update', $boxMatrix) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="greater_than" class="form-label">Greater Than</label>
                            <input type="number" name="greater_than" id="greater_than" class="form-control" value="{{ old('greater_than', $boxMatrix->greater_than) }}" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="qty_of_env" class="form-label">Qty of Env</label>
                            <input type="number" name="qty_of_env" id="qty_of_env" class="form-control" value="{{ old('qty_of_env', $boxMatrix->qty_of_env) }}" required min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="box_style" class="form-label">Box Style</label>
                        <input type="text" name="box_style" id="box_style" class="form-control" value="{{ old('box_style', $boxMatrix->box_style) }}" required maxlength="10">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="length" class="form-label">Length</label>
                            <input type="number" name="length" id="length" class="form-control" value="{{ old('length', $boxMatrix->length) }}" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="width" class="form-label">Width</label>
                            <input type="number" name="width" id="width" class="form-control" value="{{ old('width', $boxMatrix->width) }}" required min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="number" name="height" id="height" class="form-control" value="{{ old('height', $boxMatrix->height) }}" required min="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="empty_weight" class="form-label">Empty Weight</label>
                            <input type="number" name="empty_weight" id="empty_weight" class="form-control" value="{{ old('empty_weight', $boxMatrix->empty_weight) }}" required min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="full_weight" class="form-label">Full Weight</label>
                            <input type="number" name="full_weight" id="full_weight" class="form-control" value="{{ old('full_weight', $boxMatrix->full_weight) }}" required min="0">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger flex-fill">
                            <i class="bi bi-check-circle me-1"></i> Update Matrix
                        </button>
                        <a href="{{ route('admin.hospital-box-matrices') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 