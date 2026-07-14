@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.order-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:30px;
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.order-banner>*{
    position:relative;
    z-index:2;
}

.order-banner::before{
    content:'';
    position:absolute;
    width:170px;
    height:170px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    right:-40px;
    top:-50px;
    pointer-events:none;
}

.order-banner::after{
    content:'';
    position:absolute;
    width:110px;
    height:110px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    left:-20px;
    bottom:-20px;
    pointer-events:none;
}

.order-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.order-header{
    background:#7BDFF2;
    color:white;
    padding:18px 25px;
}

.form-control,
.form-select{
    border-radius:15px;
}

.form-control:focus,
.form-select:focus{
    border-color:#55DDE0;
    box-shadow:0 0 0 .2rem rgba(85,221,224,.25);
}

.info-box{
    background:#F4FDFF;
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
    border-left:5px solid #55DDE0;
}

.total-box{
    background:#EAFBFF;
    border:2px dashed #7BDFF2;
    border-radius:20px;
    padding:20px;
    text-align:center;
}

.total-box h5{
    color:#4B5563;
    margin-bottom:10px;
}

.total-price{
    font-size:34px;
    font-weight:bold;
    color:#0EA5E9;
}

.btn-bubble{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
    padding:10px 24px;
}

.btn-bubble:hover{
    background:#39CCD3;
    color:white;
}

</style>

<div class="container py-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="order-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🧺 Buat Pesanan Laundry</h2>

<p class="mb-0">

Isi data pesananmu lalu lihat estimasi total secara otomatis 🫧

</p>

</div>

<a href="{{ route('orders.index') }}"
class="btn btn-light rounded-pill">

⬅ Kembali

</a>

</div>

</div>

<div class="card order-card">

<div class="order-header">

<h4 class="mb-0">

📝 Form Pemesanan

</h4>

</div>

<div class="card-body">

<form action="{{ route('orders.store') }}" method="POST">

@csrf

<div class="info-box">

<label for="package_id" class="form-label fw-bold">

🧺 Pilih Paket Laundry

</label>

<select
name="package_id"
id="package_id"
class="form-select @error('package_id') is-invalid @enderror"
required>

<option value="">-- Pilih Paket Laundry --</option>

@foreach($packages as $package)

<option
value="{{ $package->id }}"
data-price="{{ $package->price }}"
{{ request('package') == $package->id ? 'selected' : '' }}>

{{ $package->name }}
- Rp {{ number_format($package->price,0,',','.') }}/kg

</option>

@endforeach

</select>

@error('package_id')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>
<div class="mb-3">

<label for="weight" class="form-label fw-bold">

⚖ Berat Cucian (kg)

</label>

<input
type="number"
name="weight"
id="weight"
step="0.1"
min="0.5"
value="{{ old('weight') }}"
class="form-control @error('weight') is-invalid @enderror"
placeholder="Contoh: 2.5"
required>

@error('weight')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>

<div class="mb-3">

<label for="pickup_date" class="form-label fw-bold">

📅 Tanggal Ambil

</label>

<input
type="date"
name="pickup_date"
id="pickup_date"
value="{{ old('pickup_date') }}"
class="form-control @error('pickup_date') is-invalid @enderror"
required>

@error('pickup_date')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>

<div class="mb-3">

<label for="note" class="form-label fw-bold">

📝 Catatan

</label>

<textarea
name="note"
id="note"
rows="4"
class="form-control @error('note') is-invalid @enderror"
placeholder="Contoh: Tolong jangan gunakan pewangi.">{{ old('note') }}</textarea>

@error('note')
<div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>

<div class="total-box mb-4">

<h5>🫧 Estimasi Total Harga</h5>

<div class="total-price" id="totalPrice">

Rp 0

</div>

</div>

<div class="d-flex gap-2">

<button type="submit" class="btn btn-bubble">

🛒 Buat Pesanan

</button>

<a
href="{{ route('orders.index') }}"
class="btn btn-outline-secondary rounded-pill">

Batal

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script>

const packageSelect=document.getElementById('package_id');

const weight=document.getElementById('weight');

const total=document.getElementById('totalPrice');

function hitungTotal(){

    let harga=0;

    if(packageSelect.selectedIndex>0){

        harga=packageSelect.options[packageSelect.selectedIndex].dataset.price;

    }

    let berat=weight.value||0;

    let hasil=harga*berat;

    total.innerHTML='Rp '+Number(hasil).toLocaleString('id-ID');

}

packageSelect.addEventListener('change',hitungTotal);

weight.addEventListener('input',hitungTotal);

window.addEventListener('load',hitungTotal);

</script>

@endsection