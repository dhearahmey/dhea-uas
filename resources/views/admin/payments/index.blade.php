@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.payment-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:30px;
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.payment-banner::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    top:-60px;
    right:-40px;
}

.payment-banner::after{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    bottom:-30px;
    left:-20px;
}

.payment-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.payment-card .card-header{
    background:white;
    border:none;
    font-weight:bold;
    font-size:22px;
    padding:20px 25px;
}

.table{
    margin-bottom:0;
}

.table thead{
    background:#EAFBFF;
}

.table thead th{
    border:none;
    font-weight:700;
}

.table td{
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#F7FDFF;
}

.badge{
    border-radius:30px;
    padding:8px 14px;
    font-size:13px;
}

.btn-proof{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
}

.btn-proof:hover{
    background:#3CCED3;
    color:white;
}

.btn-success,
.btn-danger{
    border-radius:30px;
}

.pagination{
    justify-content:center;
}

</style>

<div class="container py-4">

@if(session('success'))

<div class="alert alert-success rounded-4 shadow-sm">

✅ {{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger rounded-4 shadow-sm">

❌ {{ session('error') }}

</div>

@endif

<div class="payment-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="fw-bold">

💳 Verifikasi Pembayaran

</h2>

<p class="mb-0">

Periksa bukti pembayaran pelanggan sebelum memproses pesanan.

</p>

</div>

<div style="font-size:70px;">

🧾

</div>

</div>

</div>

<div class="card payment-card">

<div class="card-header">

Daftar Pembayaran

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No. Order</th>

<th>Customer</th>

<th>Paket</th>

<th>Jumlah</th>

<th>Metode</th>

<th>Status</th>

<th>Tanggal</th>

<th>Bukti</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>

<strong>{{ $payment->order->order_number }}</strong>

</td>

<td>{{ $payment->order->user->name }}</td>

<td>{{ $payment->order->package->name }}</td>

<td>

<strong>

Rp {{ number_format($payment->amount,0,',','.') }}

</strong>

</td>

<td>

<span class="badge bg-info">

{{ strtoupper($payment->method) }}

</span>

</td>

<td>

@if($payment->status=='pending')

<span class="badge bg-warning text-dark">

⏳ Menunggu

</span>

@elseif($payment->status=='verified')

<span class="badge bg-success">

✅ Diverifikasi

</span>

@else

<span class="badge bg-danger">

❌ Ditolak

</span>

@endif

</td>

<td>

{{ $payment->created_at->format('d/m/Y H:i') }}

</td>

<td>
    @if($payment->proof_image)

<a
href="{{ asset('storage/'.$payment->proof_image) }}"
target="_blank"
class="btn btn-proof btn-sm">

👁 Lihat

</a>

@else

<span class="text-muted">

Tidak ada

</span>

@endif

</td>

<td>

@if($payment->status=='pending')

<div class="d-flex gap-2 flex-wrap">

<form
action="{{ route('admin.payments.verify',$payment) }}"
method="POST">

@csrf
@method('PUT')

<button
type="submit"
class="btn btn-success btn-sm rounded-pill px-3"
onclick="return confirm('Verifikasi pembayaran ini?')">

✅ Verifikasi

</button>

</form>

<form
action="{{ route('admin.payments.reject',$payment) }}"
method="POST">

@csrf
@method('PUT')

<button
type="submit"
class="btn btn-danger btn-sm rounded-pill px-3"
onclick="return confirm('Tolak pembayaran ini?')">

❌ Tolak

</button>

</form>

</div>

@else

<span class="text-muted">

-

</span>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="9" class="text-center py-5">

<div style="font-size:65px;">

🫧

</div>

<h5 class="mt-3">

Tidak ada pembayaran yang menunggu verifikasi

</h5>

<p class="text-muted mb-0">

Semua pembayaran sudah diproses.

</p>

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@if(method_exists($payments,'links'))

<div class="mt-4">

{{ $payments->links() }}

</div>

@endif

</div>

</div>

</div>

@endsection