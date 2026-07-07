@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Paket Laundry</h3>
                    <a href="{{ route('packages.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
                </div>
                <div class="card-body">
                    <h4>{{ $package->name }}</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tipe:</strong> {{ ucfirst(str_replace('_', ' ', $package->type)) }}</p>
                            <p><strong>Harga:</strong> Rp {{ number_format($package->price, 0, ',', '.') }} / kg</p>
                            <p><strong>Durasi:</strong> {{ $package->duration }} jam</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $package->is_active ? 'success' : 'danger' }}">
                                    {{ $package->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Deskripsi:</strong></p>
                            <p>{{ $package->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                    
                    @auth
                        @if(!Auth::user()->isAdmin())
                            <div class="mt-3">
                                <a href="{{ route('orders.create') }}?package={{ $package->id }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                                </a>
                            </div>
                        @endif
                        
                        @if(Auth::user()->isAdmin())
                            <div class="mt-3">
                                <a href="{{ route('packages.edit', $package) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Yakin hapus paket ini?')">Hapus</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection