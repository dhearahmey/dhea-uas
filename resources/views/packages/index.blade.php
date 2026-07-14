@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.page-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:35px;
    margin-bottom:30px;
    box-shadow:0 12px 25px rgba(0,0,0,.08);
    position:relative;
    overflow:hidden;
}

.page-banner::before{
    content:'';
    width:180px;
    height:180px;
    background:rgba(255,255,255,.15);
    border-radius:50%;
    position:absolute;
    right:-40px;
    top:-50px;
}

.page-banner::after{
    content:'';
    width:120px;
    height:120px;
    background:rgba(255,255,255,.18);
    border-radius:50%;
    position:absolute;
    left:-20px;
    bottom:-20px;
}

.package-card{
    border:none;
    border-radius:22px;
    overflow:hidden;
    transition:.3s;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    height:100%;
}

.package-card:hover{
    transform:translateY(-8px);
}

.price{
    color:#0EA5E9;
    font-size:22px;
    font-weight:bold;
}

.btn-detail{
    background:#7BDFF2;
    color:white;
    border:none;
    border-radius:30px;
}

.btn-detail:hover{
    background:#55DDE0;
    color:white;
}

.btn-edit{
    border-radius:30px;
}

.btn-delete{
    border-radius:30px;
}

</style>

<div class="container py-4">

<div class="page-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🧺 Paket Laundry</h2>

<p class="mb-0">

Pilih paket laundry sesuai kebutuhanmu 🫧

</p>

</div>

@auth

@if(Auth::user()->isAdmin())

<a href="{{ route('packages.create') }}"
class="btn btn-light rounded-pill px-4">

➕ Tambah Paket

</a>

@endif

@endauth

</div>

</div>

<div class="row">

@foreach($packages as $package)
<div class="col-md-4 mb-4">

    <div class="card package-card">

        <div class="card-body d-flex flex-column">

            <div class="text-center mb-3" style="font-size:55px;">
                🧺
            </div>

            <h4 class="fw-bold text-center">

                {{ $package->name }}

            </h4>

            <p class="text-muted text-center">

                {{ $package->description ?? 'Tidak ada deskripsi.' }}

            </p>

            <div class="text-center my-3">

                <div class="price">

                    Rp {{ number_format($package->price,0,',','.') }}

                </div>

                <small class="text-muted">

                    / kg

                </small>

            </div>

            <div class="text-center mb-3">

                ⏱ Estimasi

                <strong>{{ $package->duration }} Jam</strong>

            </div>

            <div class="mt-auto text-center">

                <a href="{{ route('packages.show',$package) }}"
                   class="btn btn-detail">

                    👀 Detail

                </a>

                @auth

                @if(Auth::user()->isAdmin())

                    <a href="{{ route('packages.edit',$package) }}"
                       class="btn btn-warning btn-edit">

                        ✏ Edit

                    </a>

                    <form action="{{ route('packages.destroy',$package) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-delete"
                                onclick="return confirm('Yakin ingin menghapus paket ini?')">

                            🗑 Hapus

                        </button>

                    </form>

                @endif

                @endauth

            </div>

        </div>

    </div>

</div>

@endforeach

</div>

</div>

@endsection