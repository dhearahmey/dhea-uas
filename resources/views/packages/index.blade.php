@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Paket Laundry</h1>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('packages.create') }}" class="btn btn-primary">Tambah Paket</a>
            @endif
        @endauth
    </div>

    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $package->name }}</h5>
                    <p class="card-text">{{ $package->description ?? 'Tidak ada deskripsi' }}</p>
                    <h6 class="text-primary">Rp {{ number_format($package->price, 0, ',', '.') }} / kg</h6>
                    <small class="text-muted">Estimasi: {{ $package->duration }} jam</small>
                    <br>
                    <a href="{{ route('packages.show', $package) }}" class="btn btn-sm btn-info mt-2">Detail</a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('packages.edit', $package) }}" class="btn btn-sm btn-warning mt-2">Edit</a>
                            <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger mt-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection