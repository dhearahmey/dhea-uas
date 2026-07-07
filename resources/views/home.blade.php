@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->isAdmin())
                        <div class="alert alert-info">
                            <i class="fas fa-user-shield me-2"></i> Anda login sebagai <strong>Administrator</strong>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-user me-2"></i> Selamat datang, <strong>{{ Auth::user()->name }}</strong>! 
                            Anda login sebagai <strong>User</strong>
                        </div>
                    @endif

                    <p class="mt-3">Anda berhasil login ke sistem <strong>LaundryKu</strong>! 🧺</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection