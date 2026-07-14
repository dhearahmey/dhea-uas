@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.detail-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:30px;
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.detail-banner>*{
    position:relative;
    z-index:2;
}

.detail-banner::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    top:-60px;
    right:-50px;
}

.detail-banner::after{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    bottom:-30px;
    left:-30px;
}

.card-bubble{
    border:none;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.card-bubble .card-header{
    background:#7BDFF2;
    color:white;
    font-weight:bold;
    border:none;
}

.info-item{
    background:#F5FCFF;
    border-radius:15px;
    padding:12px 15px;
    margin-bottom:10px;
}

.timeline-item{
    background:#F8FDFF;
    border-left:5px solid #55DDE0;
    border-radius:12px;
    padding:15px;
    margin-bottom:15px;
}

.btn-bubble{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
}

.btn-bubble:hover{
    background:#39CCD3;
    color:white;
}

</style>

<div class="container py-4">

<div class="detail-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🧺 Detail Pesanan</h2>

<p class="mb-0">

Order #{{ $order->order_number }}

</p>

</div>

<a href="{{ route('orders.index') }}" class="btn btn-light rounded-pill">

⬅ Kembali

</a>

</div>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<div class="row">

<div class="col-lg-6">

<div class="card card-bubble mb-4">

<div class="card-header">

📋 Informasi Pesanan

</div>

<div class="card-body">

<div class="info-item">

<strong>No Order</strong><br>

{{ $order->order_number }}

</div>

<div class="info-item">

<strong>Paket</strong><br>

{{ $order->package->name }}

</div>

<div class="info-item">

<strong>Berat</strong><br>

{{ $order->weight }} kg

</div>

<div class="info-item">

<strong>Total</strong><br>

<b class="text-primary">

Rp {{ number_format($order->total_price,0,',','.') }}

</b>

</div>

<div class="info-item">

<strong>Status</strong><br>

<span class="badge bg-{{ $order->status_badge }} rounded-pill">

{{ $order->status_label }}

</span>

</div>
<div class="info-item">

<strong>Tanggal Ambil</strong><br>

{{ $order->pickup_date->format('d/m/Y') }}

</div>

@if($order->delivery_date)

<div class="info-item">

<strong>Tanggal Selesai</strong><br>

{{ $order->delivery_date->format('d/m/Y') }}

</div>

@endif

<div class="info-item">

<strong>Catatan</strong><br>

{{ $order->note ?? '-' }}

</div>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card card-bubble mb-4">

<div class="card-header">

💳 Pembayaran

</div>

<div class="card-body">

@if($order->payment)

<div class="info-item">

<strong>Status</strong><br>

<span class="badge bg-{{ $order->payment->status=='verified' ? 'success' : ($order->payment->status=='rejected' ? 'danger' : 'warning') }} rounded-pill">

{{ $order->payment->status_label }}

</span>

</div>

<div class="info-item">

<strong>Metode</strong><br>

{{ strtoupper($order->payment->method) }}

</div>

<div class="info-item">

<strong>Jumlah</strong><br>

Rp {{ number_format($order->payment->amount,0,',','.') }}

</div>

@if($order->payment->proof_image)

<a
href="{{ asset('storage/'.$order->payment->proof_image) }}"
target="_blank"
class="btn btn-info rounded-pill">

🖼 Lihat Bukti

</a>

@endif

@if($order->payment->status=='rejected')

<a
href="{{ route('payments.create',$order) }}"
class="btn btn-warning rounded-pill">

🔄 Upload Ulang

</a>

@endif

@else

<p class="text-center text-muted">

Belum ada pembayaran.

</p>

@if($order->status=='pending')

<div class="text-center">

<a
href="{{ route('payments.create',$order) }}"
class="btn btn-bubble">

💳 Upload Bukti Pembayaran

</a>

</div>

@endif

@endif

</div>

</div>

</div>

</div>

<div class="card card-bubble mb-4">

<div class="card-header">

📍 Tracking Pesanan

</div>

<div class="card-body">

@if($order->trackings->count())

@foreach($order->trackings as $tracking)

<div class="timeline-item">

<span class="badge bg-{{ $tracking->status=='completed' ? 'success' : ($tracking->status=='cancelled' ? 'danger' : 'info') }} rounded-pill">

{{ $tracking->status_label ?? $tracking->status }}

</span>

<p class="mt-2 mb-1">

{{ $tracking->description }}

</p>

<small class="text-muted">

{{ $tracking->created_at->format('d/m/Y H:i') }}

</small>

</div>

@endforeach

@else

<p class="text-center text-muted">

Belum ada tracking pesanan.

</p>

@endif

</div>

</div>

@auth

@if(Auth::user()->isAdmin())

<div class="card card-bubble">

<div class="card-header">

⚙ Admin Action

</div>

<div class="card-body">

<form
action="{{ route('admin.orders.updateStatus',$order) }}"
method="POST">

@csrf

@method('PUT')

<div class="row">

<div class="col-md-8">

<select
name="status"
class="form-select">

<option value="pending" {{ $order->status=='pending' ? 'selected' : '' }}>
Menunggu Pembayaran
</option>

<option value="processing" {{ $order->status=='processing' ? 'selected' : '' }}>
Diproses
</option>

<option value="ready" {{ $order->status=='ready' ? 'selected' : '' }}>
Siap Diambil
</option>

<option value="delivered" {{ $order->status=='delivered' ? 'selected' : '' }}>
Sudah Diambil
</option>

<option value="completed" {{ $order->status=='completed' ? 'selected' : '' }}>
Selesai
</option>

<option value="cancelled" {{ $order->status=='cancelled' ? 'selected' : '' }}>
Dibatalkan
</option>

</select>

</div>

<div class="col-md-4">

<button
type="submit"
class="btn btn-bubble w-100">

💾 Update

</button>

</div>

</div>

</form>

</div>

</div>

@endif

@endauth

</div>

@endsection