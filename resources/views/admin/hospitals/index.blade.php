@extends('layouts.app')

@section('title', 'Hospital Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-danger text-white py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap">

                    <!-- Left: Title -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-heart-pulse display-6 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Hospital Management</h4>
                            <small class="opacity-75">Manage participating hospitals and healthcare
                                organizations</small>
                        </div>
                    </div>

                    <!-- Buttons: all in one row -->
                    <div class="d-flex flex-grow-1 flex-wrap justify-content-end gap-2">
                        <button class="btn btn-light btn-lg shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#reportsModal">
                            <i class="bi bi-bar-chart-line me-2"></i> Reports
                        </button>

                        <!-- SendGrid CSV -->
                        <button type="button" class="btn btn-light btn-lg shadow-sm export-btn" data-bs-toggle="modal"
                            data-bs-target="#exportModal" data-route="{{ route('admin.hospitals.sendgrid.export') }}">
                            <i class="bi bi-download me-2"></i> SendGrid CSV
                        </button>

                        <!-- FedEx CSV -->
                        <button type="button" class="btn btn-light btn-lg shadow-sm export-btn" data-bs-toggle="modal"
                            data-bs-target="#exportModal" data-route="{{ route('admin.hospitals.fedex.export') }}">
                            <i class="bi bi-download me-2"></i> FedEx CSV
                        </button>

                        <a href="{{ route('admin.hospitals.create') }}" class="btn btn-light btn-lg shadow-sm">
                            <i class="bi bi-plus-lg me-2"></i> Add Record
                        </a>

                        <button type="button" class="btn btn-light btn-lg shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="bi bi-upload me-2"></i> Import
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datalist" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 60px;">
                                    <i class="bi bi-hash"></i>
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-heart-pulse me-1"></i>Organization Name
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-building me-1"></i>Organization Type
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-person me-1"></i>Contact Person
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-envelope me-1"></i>Contact Info
                                </th>
                                <th scope="col" style="min-width: 250px;">
                                    <i class="bi bi-geo-alt me-1"></i>Address
                                </th>
                                <th scope="col" class="text-center" style="min-width: 200px;">
                                    <i class="bi bi-heart me-1"></i>Valentine Cards
                                </th>
                                <th scope="col" class="text-center" style="min-width: 200px;">
                                    <i class="bi bi-collection-fill me-1"></i> Total Cards
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-tag me-1"></i>Box Style
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-arrows-angle-expand me-1"></i>Dimensions
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-box me-1"></i>Empty Weight
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-weight me-1"></i>Full Weight
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-person-badge me-1"></i>Volunteer
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-link-45deg me-1"></i>Prefilled Link
                                </th>
                                <th scope="col" class="text-center" style="min-width: 200px;">
                                    <i class="bi bi-toggle-on me-1"></i>Status
                                </th>
                                <th scope="col" style="min-width: 150px;">
                                    <i class="bi bi-flag me-1"></i>New/Update
                                </th>
                                <th scope="col" style="min-width: 200px;">
                                    <i class="bi bi-clock-history me-1"></i>Last Updated
                                </th>
                                <th scope="col" class="sticky-action-col text-center"
                                    style="z-index:3; min-width: 120px;">
                                    <i class="bi bi-gear me-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hospitals as $hospital)
                            <tr class="border-bottom">
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">{{ $hospital->reference }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $hospital->organization_name }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $hospital->organization_type }}</div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="fw-semibold">{{ $hospital->contact_person_name }}</div>
                                        <small class="text-muted">{{ $hospital->how_to_address }}</small>
                                        <small class="text-muted">{{ $hospital->contact_title }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-envelope text-muted me-1"></i>
                                            <span class="fw-semibold">{{ $hospital->email }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-telephone text-muted me-1"></i>
                                            <span class="text-muted">{{ $hospital->phone }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ $hospital->street }}</small>
                                        <small class="text-muted">
                                            {{ $hospital->city }}
                                            {{ $hospital->county ? ', ' . $hospital->county . ' County' : '' }},
                                            {{ $hospital->state }} {{ $hospital->zip }}
                                        </small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge bg-danger">{{ $hospital->valentine_card_count }} Valentine
                                            Cards</span>
                                        <span class="badge bg-info">{{ $hospital->extra_staff_cards }} Staff
                                            Cards</span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success text-white fs-6 px-3 py-2">{{ $hospital->valentine_card_count + $hospital->extra_staff_cards }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6 px-3 py-2">{{ $hospital->box_style }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">L: {{ $hospital->length }} × W: {{ $hospital->width }}
                                            × H: {{ $hospital->height }}</small>
                                        <small
                                            class="text-success fw-semibold">{{ $hospital->length * $hospital->width * $hospital->height }}
                                            cm³</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $hospital->empty_weight }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-info">{{ $hospital->full_weight }}g</span>
                                </td>
                                <td>
                                    @if($hospital->volunteer)
                                    <div class="d-flex flex-column">
                                        <div class="fw-semibold">{{ $hospital->volunteer->name }}</div>
                                        <small class="text-muted">{{ $hospital->volunteer->email }}</small>
                                    </div>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td style="max-width: 250px;">
                                    {{-- @if($hospital->prefilled_link) --}}
                                    <a href="{{ route('hospital.edit', $hospital->token) }}" target="_blank"
                                        class="text-decoration-none">
                                        <!-- <i class="bi bi-box-arrow-up-right me-1"></i>Open Form -->
                                        {{ $hospital->prefilled_link }}
                                    </a>
                                    {{-- @else
                                            <span class="text-muted">—</span>
                                        @endif --}}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        @if($hospital->standing_order)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Standing Order
                                        </span>
                                        @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>No Standing Order
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        @if ($hospital->update_status)
                                        <span>Update</span>
                                        @else
                                        <span>New</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $hospital->updated_at->format('Ymd') }}</span>
                                        <small class="text-muted">{{ $hospital->updated_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td class="sticky-action-col bg-light text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.hospitals.edit', $hospital) }}"
                                            class="btn btn-outline-primary btn-sm" title="Edit Hospital">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.hospitals.delete', $hospital) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this hospital? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Delete Hospital">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-heart-pulse display-1 text-muted mb-3"></i>
                                        <h5 class="text-muted mb-3">No hospitals found</h5>
                                        <p class="text-muted mb-4">Start by adding your first participating hospital or
                                            healthcare organization.</p>
                                        <a href="#" class="btn btn-danger btn-lg shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#importModal">
                                            <i class="bi bi-upload me-2"></i>Import
                                        </a>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
            @if($hospitals->count() > 0)
            <div class="card-footer bg-light text-center py-3">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-heart-pulse me-1"></i>
                            Total Hospitals: {{ $hospitals->count() }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-check-circle me-1"></i>
                            Standing Orders: {{ $hospitals->where('standing_order', true)->count() }}
                        </small>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">
                            <i class="bi bi-envelope-check me-1"></i>
                            Updated: {{ $hospitals->where('updated_status', true)->count() }}
                        </small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.table> :not(caption)>*>* {
    padding: 1rem 0.75rem;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin: 0 2px;
}

/* thead th {
        position: sticky;
        top: 0;
        background-color: #f8d7da;
        z-index: 3;
    }
    .sticky-action-col {
        position: sticky;
        right: 0;
        z-index: 2;
        background: inherit;
    } */
.card-header .btn-lg {
    padding: 0.5rem 0.6rem;
    font-size: 1rem;
}
</style>

<!-- Import Confirmation Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.hospitals.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-upload me-2"></i> Import Hospitals CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label fw-semibold">Choose CSV File</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                    </div>
                    <small class="text-muted">CSV must match the format: Organization Name, Valentine Card Count, Extra
                        Staff Cards, Street, City, State, Zip, Phone …</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-circle me-2"></i> Import
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- REPORTS MODAL --}}
<div class="modal fade" id="reportsModal" tabindex="-1" aria-labelledby="reportsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportsModalLabel">Reports & Exports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Filters --}}
                <form id="report-filters" class="row g-2 mb-3">
                    <div class="col-md-2">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" placeholder="CA">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Hospital Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Search name">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Min Valentine Cards</label>
                        <input type="number" name="min_valentine_cards" class="form-control" min="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Max Valentine Cards</label>
                        <input type="number" name="max_valentine_cards" class="form-control" min="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Standing Order</label>
                        <select name="standing_order" class="form-select">
                            <option value="">Any</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">New/Update</label>
                        <select name="update_status" class="form-select">
                            <option value="">Any</option>
                            <option value="new">New</option>
                            <option value="update">Updated</option>
                        </select>
                    </div>
                </form>

                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <button id="run-report" class="btn btn-danger">
                            <i class="bi bi-filter-circle me-1"></i> Run Report
                        </button>
                    </div>
                    <div class="btn-group">
                        <a id="export-csv" class="btn btn-outline-secondary"><i class="bi bi-download me-1"></i>CSV</a>
                        <a id="export-xlsx" class="btn btn-outline-secondary"><i
                                class="bi bi-download me-1"></i>Excel</a>
                        <a id="export-pdf" class="btn btn-outline-secondary"><i
                                class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
                        {{-- Optional Google Sheets --}}
                        {{-- <button id="export-sheets" class="btn btn-outline-secondary"><i class="bi bi-google me-1"></i>Google Sheets</button> --}}
                    </div>
                </div>

                <table id="reportTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="min-width: 200px;">Organization</th>
                            <th style="min-width: 200px;">Contact Person</th>
                            <th style="min-width: 200px;">Contact Info</th>
                            {{-- <th>Email</th>
                <th>Phone</th> --}}
                            <th style="min-width: 100px;">Street</th>
                            <th style="min-width: 100px;">City</th>
                            <th style="min-width: 100px;">State</th>
                            <th style="min-width: 100px;">ZIP</th>
                            <th style="min-width: 100px;">Valentine Cards</th>
                            <th style="min-width: 100px;">Staff Cards</th>
                            <th style="min-width: 100px;">Total Cards</th>
                            <th style="min-width: 100px;">Box</th>
                            <th style="min-width: 100px;">Empty Weight</th>
                            <th style="min-width: 100px;">Full Weight</th>
                            <th style="min-width: 200px;">Prefilled Link</th>
                            <th style="min-width: 200px;">Notes from Hosp/Organization</th>
                            <th style="min-width: 200px;">Internal Notes</th>
                            <th style="min-width: 100px;">New/Update</th>
                            <th style="min-width: 100px;">Last Updated</th>
                            {{-- <th>Standing</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="GET" id="exportForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Export Scope</label>
                        <select name="scope" id="exportScope" class="form-select">
                            <option value="all" selected>All</option>
                            <option value="since">New/Edited Since</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="date" name="since" id="sinceDate" class="form-control" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Export CSV</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
let reportTable;

function filtersQS() {
    const data = $('#report-filters').serialize();
    return data ? ('?' + data) : '';
}

function initOrReloadTable() {
    const url = "{{ route('admin.hospitals.reports.data') }}" + filtersQS();

    if (reportTable) {
        reportTable.ajax.url(url).load();
        return;
    }

    reportTable = $('#reportTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: url,
        columns: [{
                data: 'reference'
            },
            {
                data: 'organization_name'
            },
            {
                data: null,
                render: d => `
                        ${d.contact_person_name || ''}<br>
                        <small>${d.how_to_address || ''}</small><br>
                        <small>${d.contact_title || ''}</small>
                    `
            },
            {
                data: null,
                render: d => `
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope text-muted me-1"></i>
                            <span class="fw-semibold">${d.email || ''}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone text-muted me-1"></i>
                            <span class="text-muted">${d.phone || ''}</span>
                        </div>
                    `
            },
            {
                data: 'street'
            },
            {
                data: 'city'
            },
            {
                data: 'state'
            },
            {
                data: 'zip'
            },
            {
                data: 'valentine_card_count'
            },
            {
                data: 'extra_staff_cards'
            },
            {
                data: null,
                render: d => (parseInt(d.valentine_card_count || 0) + parseInt(d.extra_staff_cards || 0))
            },
            {
                data: null,
                render: d => `
                        ${d.box_style || ''}<br>
                        ${d.length}x${d.width}x${d.height}
                    `
            },
            {
                data: 'empty_weight'
            },
            {
                data: 'full_weight'
            },
            {
                data: 'prefilled_link'
            },
            {
                data: 'public_notes'
            },
            {
                data: 'internal_notes'
            },
            {
                data: 'update_status',
                render: function (data) {
                    return (!data) ? 'New' : 'Update';
                }
            },
            {
                data: 'updated_at',
                render: function(data) {
                    if (!data) return '-';
                    const formatted = dayjs.utc(data).tz("America/New_York").format('MMM DD, YYYY');
                    const human = dayjs.utc(data).tz("America/New_York").fromNow();
                    return `
                            <span class="fw-semibold">${formatted}</span><br>
                            <small class="text-muted">${human}</small>
                        `;
                }
            }
            // { data: 'standing_order', render: v => v ? 'Yes' : 'No' },
            // { data: 'update_status', render: v => v ? 'Updated' : '—' },
        ],
        order: [
            [0, 'asc']
        ],
        pageLength: 10
    });
}

$('#run-report').on('click', function() {
    initOrReloadTable();
});

function exportUrl(type) {
    return "{{ route('admin.hospitals.reports.export', ['type' => '___']) }}".replace('___', type) + filtersQS();
}

$('#export-csv').on('click', () => window.location.href = exportUrl('csv'));
$('#export-xlsx').on('click', () => window.location.href = exportUrl('xlsx'));
$('#export-pdf').on('click', () => window.location.href = exportUrl('pdf'));

// Optional Google Sheets (POST to keep credentials out of URL)
// $('#export-sheets').on('click', function() {
//   const form = $('<form>', {method:'POST', action: "{{ route('admin.hospitals.reports.export.sheets') }}"});
//   form.append('@csrf');
//   const pairs = $('#report-filters').serializeArraysmall flame april receive struggle near autumn enforce stuff enforce cube armed();
//   pairs.forEach(p => form.append($('<input>', {type:'hidden', name:p.name, value:p.value})));
//   $('body').append(form); form.submit();
// });

$(document).ready(function() {
    $('#datalist').DataTable({
        scrollX: true,
        scrollY: '400px', // set table height
        scrollCollapse: true, // shrink table if fewer rows
        paging: true, // enable pagination
        searching: true, // enable search
        ordering: true, // enable column sorting
        info: true, // show "Showing X of Y" info
        pageLength: 10, // default rows per page
        columnDefs: [{
                orderable: false,
                targets: -1
            }, // disable sorting for the Actions column
        ],
        fixedColumns: {
            rightColumns: 1 // freeze the last column
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const exportButtons = document.querySelectorAll(".export-btn");
    const exportForm = document.getElementById("exportForm");
    const exportScope = document.getElementById("exportScope");
    const sinceDate = document.getElementById("sinceDate");

    // Open modal with correct route
    exportButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            let route = this.getAttribute("data-route");
            exportForm.setAttribute("action", route);

            // Reset defaults
            exportScope.value = "all";
            sinceDate.disabled = true;
            sinceDate.value = "";
        });
    });

    // Enable date only when "New/Edited Since" is chosen
    exportScope.addEventListener("change", function() {
        if (this.value === "since") {
            sinceDate.disabled = false;
        } else {
            sinceDate.disabled = true;
            sinceDate.value = "";
        }
    });
});
</script>
@endsection