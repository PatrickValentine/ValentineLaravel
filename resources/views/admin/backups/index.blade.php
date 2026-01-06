@extends('layouts.app')

@section('title', 'Manage Backups')

@section('content')
    <div class="container py-4">
        <h2 class="mb-2">Available Backups</h2>

        <!-- Instructional text -->
        <p class="text-muted mb-4">
            (Saved in <strong>Backups</strong> folder – Login to Bluehost Cpanel and select <em>File Manager</em>. <br/>
            To save off-line to Google Drive, click the green <strong>"Download"</strong> button and then save it to Google Drive.)
        </p>

        @if(session('status'))
            <div class="alert alert-success">{!! session('status') !!}</div>
        @endif

        <!-- Align button to the right -->
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('admin.backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-info btn-lg">
                    <i class="bi bi-cloud-arrow-down me-2"></i> Create Backup
                </button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>{{ basename($file) }}</td>
                        <td>
                            <a href="{{ route('admin.backups.download', $file) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i> Download
                            </a>
                            <form action="{{ route('admin.backups.delete', $file) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">No backups available</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
