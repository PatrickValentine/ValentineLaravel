@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-light bg-gradient">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Header with gradient -->
                <div class="card-header bg-gradient-danger text-white text-center py-5" 
                     style="background: linear-gradient(135deg, #dc3545, #ff758c);">
                    <h1 class="display-4 fw-bold mb-3">Welcome to the Valentine Website</h1>
                    <p class="lead mb-0">Your place to connect, share, and celebrate love.</p>
                </div>

                <!-- Card Body -->
                <div class="card-body text-center py-5">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('school.register') }}" class="btn btn-lg btn-warning px-4 py-2 shadow-sm">
                            🎓 School Sign-up
                        </a>
                        <a href="{{ route('hospital.register') }}" class="btn btn-lg btn-success px-4 py-2 shadow-sm">
                            🏥 Hospital/Homes Sign-up
                        </a>
                        {{-- <a href="{{ route('login') }}" class="btn btn-lg btn-outline-danger px-4 py-2 shadow-sm">
                            🔑 Login
                        </a> --}}
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer text-center text-muted small py-3">
                    ❤️ Made with love for schools, hospitals & homes ❤️
                </div>
            </div>
        </div>
    </div>
@endsection
