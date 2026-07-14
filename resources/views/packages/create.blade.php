@extends('layouts.app')

@section('content')

<style>
    body{
        background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
    }

    .edit-banner{
        background:linear-gradient(135deg,#7BDFF2,#55DDE0);
        color:white;
        border-radius:25px;
        padding:30px;
        margin-bottom:25px;
        position:relative;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
    }

    .edit-banner::before{
        content:'';
        position:absolute;
        width:180px;
        height:180px;
        border-radius:50%;
        background:rgba(255,255,255,.15);
        top:-60px;
        right:-40px;
    }

    .edit-banner::after{
        content:'';
        position:absolute;
        width:120px;
        height:120px;
        border-radius:50%;
        background:rgba(255,255,255,.18);
        left:-20px;
        bottom:-30px;
    }

    .edit-card{
        border:none;
        border-radius:25px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
    }

    .edit-card .card-header{
        background:white;
        border:none;
        font-size:22px;
        font-weight:bold;
        padding:20px 25px;
    }

    .form-control,
    .form-select{
        border-radius:15px;
        padding:12px;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#55DDE0;
        box-shadow:0 0 10px rgba(85,221,224,.3);
    }

    .info-box{
        background:#F4FDFF;
        border-radius:15px;
        padding:18px;
        margin-bottom:20px;
    }

    .btn-save{
        background:#55DDE0;
        color:white;
        border:none;
        border-radius:30px;
        padding:10px 24px;
    }

    .btn-save:hover{
        background:#39CCD2;
        color:white;
    }

    .btn-cancel{
        border-radius:30px;
        padding:10px 24px;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Banner -->
            <div class="edit-banner">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">➕ Tambah Paket Laundry</h2>
                        <p class="mb-0">Tambahkan paket laundry baru dengan mudah.</p>
                    </div>
                    <a href="{{ route('packages.index') }}" class="btn btn-light rounded-pill">
                        ⬅ Kembali
                    </a>
                </div>
            </div>

            <!-- Card -->
            <div class="card edit-card">
                <div class="card-header">📦 Form Tambah Paket</div>
                <div class="card-body">
                    <form action="{{ route('packages.store') }}" method="POST">
                        @csrf

                        <!-- Nama Paket -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">🧺 Nama Paket</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipe Paket -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">📋 Tipe Paket</label>
                            <select name="type"
                                    class="form-select @error('type') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Tipe</option>
                                <option value="cuci_kering" {{ old('type')=='cuci_kering'?'selected':'' }}>Cuci Kering</option>
                                <option value="cuci_setrika" {{ old('type')=='cuci_setrika'?'selected':'' }}>Cuci Setrika</option>
                                <option value="express" {{ old('type')=='express'?'selected':'' }}>Express</option>
                                <option value="dry_clean" {{ old('type')=='dry_clean'?'selected':'' }}>Dry Clean</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga & Durasi dalam info-box -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="form-label fw-bold">💰 Harga / kg</label>
                                    <input type="number" name="price"
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price') }}" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <label class="form-label fw-bold">⏱️ Durasi (Jam)</label>
                                    <input type="number" name="duration"
                                           class="form-control @error('duration') is-invalid @enderror"
                                           value="{{ old('duration') }}" min="1" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="info-box">
                            <label class="form-label fw-bold">📝 Deskripsi</label>
                            <textarea name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Switch Aktif -->
                        <div class="form-check form-switch mb-4">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="is_active" value="1"
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label ms-2" for="is_active">
                                ✅ Paket Aktif
                            </label>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-save">💾 Simpan Paket</button>
                            <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary btn-cancel">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection