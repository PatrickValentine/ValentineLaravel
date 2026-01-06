@extends('layouts.app')

@section('title', 'FedEx Field Mappings')

@section('content')
<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">
                <i class="bi bi-truck me-2 text-primary"></i> Hospital Outgoing FedEx Field Mappings
            </h2>
            <small class="text-muted">Hospital Outgoing Mapping Table</small>
        </div>
        <a href="{{ route('admin.fedex_mappings.hospital_outgoing.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Mapping
        </a>
    </div>

    <!-- Card Container -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table id="fedexTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>FedEx Field</th>
                            <th>Our Field</th>
                            <th>Common Value</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mappings as $map)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $map->fedex_field }}</td>
                                <td>
                                    @if($map->our_field)
                                        <span class="badge bg-info text-dark">{{ $map->our_field }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($map->common_value)
                                        <span class="fw-semibold text-success">{{ $map->common_value }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $map->description ?? '—' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.fedex_mappings.hospital_outgoing.edit', $map) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.fedex_mappings.hospital_outgoing.destroy', $map) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this mapping?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                                    No mappings found. 
                                    <a href="{{ route('admin.fedex_mappings.hospital_outgoing.create') }}" class="fw-bold text-primary">Add one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Scripts -->
@push('scripts')
<script>
$(document).ready(function() {
    $('#fedexTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        searching: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', className: 'btn btn-outline-secondary btn-sm' },
            { extend: 'csv', className: 'btn btn-outline-success btn-sm' },
            { extend: 'excel', className: 'btn btn-outline-primary btn-sm' },
            { extend: 'pdf', className: 'btn btn-outline-danger btn-sm' },
            { extend: 'print', className: 'btn btn-outline-dark btn-sm' }
        ]
    });
});
</script>
@endpush

@endsection
