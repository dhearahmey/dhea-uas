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
    z-index:1;
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
    z-index:0;
    pointer-events:none;
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
    z-index:0;
    pointer-events:none;
}

.edit-banner>*{
    position:relative;
    z-index:2;
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

<div class="edit-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="fw-bold">

✏️ Edit Paket Laundry

</h2>

<p class="mb-0">

Perbarui informasi paket laundry dengan mudah.

</p>

</div>

<a href="{{ route('packages.index') }}"
class="btn btn-light rounded-pill"
style="position:relative;z-index:10;">

⬅ Kembali

</a>

</div>

</div>

<div class="card edit-card">

<div class="card-header">

📦 Form Edit Paket

</div>

<div class="card-body">

<form action="{{ route('packages.update',$package) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label class="form-label fw-bold">

🧺 Nama Paket

</label>

<input
type="text"
name="name"
class="form-control @error('name') is-invalid @enderror"
value="{{ old('name',$package->name) }}"
required>

@error('name')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

<div class="mb-3">

<label class="form-label fw-bold">

📋 Tipe Paket

</label>

<select
name="type"
class="form-select @error('type') is-invalid @enderror"
required>

<option value="cuci_kering" {{ $package->type=='cuci_kering'?'selected':'' }}>
Cuci Kering
</option>

<option value="cuci_setrika" {{ $package->type=='cuci_setrika'?'selected':'' }}>
Cuci Setrika
</option>

<option value="express" {{ $package->type=='express'?'selected':'' }}>
Express
</option>

<option value="dry_clean" {{ $package->type=='dry_clean'?'selected':'' }}>
Dry Clean
</option>

</select>

@error('type')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

<div class="row">

<div class="col-md-6">

<div class="info-box">

<label class="form-label fw-bold">

💰 Harga / kg

</label>

<input
type="number"
name="price"
class="form-control @error('price') is-invalid @enderror"
value="{{ old('price',$package->price) }}"
min="0"
required>

@error('price')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

</div>

<div class="col-md-6">

<div class="info-box">

<label class="form-label fw-bold">

⏱️ Durasi (Jam)

</label>

<input
type="number"
name="duration"
class="form-control @error('duration') is-invalid @enderror"
value="{{ old('duration',$package->duration) }}"
min="1"
required>

@error('duration')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

</div>

</div>

<div class="info-box">

<label class="form-label fw-bold">

📝 Deskripsi

</label>

<textarea
name="description"
rows="4"
class="form-control @error('description') is-invalid @enderror">{{ old('description',$package->description) }}</textarea>

@error('description')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

<div class="form-check form-switch mb-4">

<input
type="hidden"
name="is_active"
value="0">

<input
class="form-check-input"
type="checkbox"
name="is_active"
id="is_active"
value="1"
{{ $package->is_active ? 'checked' : '' }}>

<label class="form-check-label ms-2" for="is_active">

✅ Paket Aktif

</label>

</div>

<div class="d-flex gap-2">

<button
type="submit"
class="btn btn-save">

💾 Update Paket

</button>

<a
href="{{ route('packages.index') }}"
class="btn btn-outline-secondary btn-cancel">

Batal

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

@endsection