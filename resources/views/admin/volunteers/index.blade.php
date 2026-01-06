@extends('layouts.app')

@section('title', 'Manage Volunteers')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-people-fill me-2"></i> Volunteer Management
        </h2>
        <a href="{{ route('admin.volunteers.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> Add Volunteer
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datalist" class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="min-width: 200px;">Name</th>
                            <th scope="col" style="min-width: 200px;">Email / Phone</th>
                            <th scope="col" style="min-width: 200px;">Address</th>
                            <th scope="col" style="min-width: 200px;">Role</th>
                            <th scope="col" style="min-width: 200px;">Classification</th>
                            <th scope="col" style="min-width: 120px;">School Credit?</th>
                            <th scope="col" style="min-width: 100px;">LinkedIn</th>
                            <th scope="col" style="min-width: 100px;">Resume</th>
                            <th class="text-center" scope="col" style="min-width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($volunteers as $volunteer)
                        <tr>
                            <td class="fw-semibold">{{ $volunteer->name }}</td>
                            <td>
                                <div><a href="mailto:{{ $volunteer->email }}">{{ $volunteer->email }}</a></div>
                                <div class="text-muted small">{{ $volunteer->phone }}</div>
                            </td>
                            <td>{{ $volunteer->address }}</td>
                            <td>
                                @if($volunteer->role)
                                    <span class="badge bg-info text-dark px-3 py-2">
                                        {{ $volunteer->role }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $volunteer->classification }}</td>
                            <td>
                                @if($volunteer->needs_school_credit)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($volunteer->linkedin_url)
                                    <a href="{{ $volunteer->linkedin_url }}" target="_blank" class="btn btn-sm btn-link text-primary">
                                        <i class="bi bi-linkedin"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($volunteer->resume_url)
                                    <a href="{{ $volunteer->resume_url }}" target="_blank" class="btn btn-sm btn-link text-success">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.volunteers.edit', $volunteer) }}" 
                                class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.volunteers.delete', $volunteer) }}" 
                                    method="POST" class="d-inline" 
                                    onsubmit="return confirm('Delete this volunteer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center text-muted py-4">
                            <td colspan="9"><i class="bi bi-person-slash fs-4 d-block mb-2"></i>No volunteers found.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datalist').DataTable({
            scrollX: true,
            scrollY: '400px',      // set table height
            scrollCollapse: true,  // shrink table if fewer rows
            paging: true,          // enable pagination
            searching: true,       // enable search
            ordering: true,        // enable column sorting
            info: true,            // show "Showing X of Y" info
            pageLength: 10,        // default rows per page
            columnDefs: [
                { orderable: false, targets: -1 }, // disable sorting for the Actions column
            ],
            fixedColumns: {
                rightColumns: 1  // freeze the last column
            }
        });
    });
</script>
@endsection
