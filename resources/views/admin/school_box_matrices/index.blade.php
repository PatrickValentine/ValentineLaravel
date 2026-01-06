@extends('layouts.app')

@section('title', 'School Box Size Matrix Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-danger text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-box-seam display-6 me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">School Box Size Matrix Management</h4>
                        <small class="opacity-75">Manage your box size configurations</small>
                    </div>
                </div>
                <a href="{{ route('admin.school-box-matrices.create') }}" class="btn btn-light btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Add New Matrix
                </a>
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
                                    <i class="bi bi-arrow-up-circle me-1"></i>Greater Than
                                </th>
                                <th scope="col">
                                    <i class="bi bi-envelope me-1"></i>Qty of Env
                                </th>
                                <th scope="col">
                                    <i class="bi bi-tag me-1"></i>Box Style
                                </th>
                                <th scope="col">
                                    <i class="bi bi-arrows-angle-expand me-1"></i>Dimensions
                                </th>
                                <th scope="col">
                                    <i class="bi bi-box me-1"></i>Empty Weight
                                </th>
                                <th scope="col">
                                    <i class="bi bi-weight me-1"></i>Full Weight
                                </th>
                                <th scope="col" class="text-center" style="width: 200px;">
                                    <i class="bi bi-gear me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($boxMatrices as $matrix)
                                <tr class="border-bottom">
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $matrix->id }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-primary">{{ $matrix->greater_than }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $matrix->qty_of_env }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $matrix->box_style }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted">L: {{ $matrix->length }} × W: {{ $matrix->width }} × H: {{ $matrix->height }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $matrix->empty_weight }} lbs</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-info">{{ $matrix->full_weight }} lbs</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.school-box-matrices.edit', $matrix) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.school-box-matrices.delete', $matrix) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this matrix?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                                            <h5 class="text-muted mb-3">No box size matrices found</h5>
                                            <p class="text-muted mb-4">Start by creating your first box size matrix configuration.</p>
                                            <a href="{{ route('admin.school-box-matrices.create') }}" class="btn btn-danger btn-lg shadow-sm">
                                                <i class="bi bi-plus-circle me-2"></i>Create First Matrix
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($boxMatrices->count() > 0)
                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Showing {{ $boxMatrices->count() }} box size matrix{{ $boxMatrices->count() !== 1 ? 'es' : '' }}
                    </small>
                </div>
            @endif
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
</style>
@endsection 