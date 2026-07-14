@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.admin-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:30px;
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.admin-banner::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    top:-60px;
    right:-40px;
}

.admin-banner::after{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    bottom:-35px;
    left:-20px;
}

.table-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.table-card .card-header{
    background:white;
    border:none;
    padding:20px 25px;
    font-weight:bold;
    font-size:22px;
}

.table{
    margin-bottom:0;
}

.table thead{
    background:#EAFBFF;
}

.table thead th{
    border:none;
    color:#0F172A;
    font-weight:700;
}

.table tbody tr:hover{
    background:#F7FDFF;
    transition:.2s;
}

.table td{
    vertical-align:middle;
}

.badge{
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
}

.btn-detail{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
    padding:7px 18px;
}

.btn-detail:hover{
    background:#39CCD2;
    color:white;
}

.pagination{
    justify-content:center;
    margin-top:20px;
}

</style>

<div class="container py-4">

@if(session('success'))
<div class="alert alert-success rounded-4 shadow-sm">
{{ session('success') }}
</div>
@endif

<div class="admin-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="fw-bold mb-2">

🧺 Kelola Pesanan

</h2>

<p class="mb-0">

Pantau seluruh pesanan pelanggan dengan mudah.

</p>

</div>

<div style="font-size:70px">

📋

</div>

</div>

</div>

<div class="card table-card">

<div class="card-header">

Daftar Pesanan

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No. Order</th>

<th>Customer</th>

<th>Paket</th>

<th>Total</th>

<th>Status</th>

<th>Tanggal</th>

<th class="text-center">Aksi</th>

</tr>

</thead>

<tbody>

@forelse($orders as $order)

<tr>

<td>{{ $order->order_number }}</td>

<td>{{ $order->user->name }}</td>

<td>{{ $order->package->name }}</td>

<td>

<strong>

Rp {{ number_format($order->total_price,0,',','.') }}

</strong>

</td>

<td>

<span class="badge bg-{{ $order->status_badge }}">

{{ $order->status_label }}

</span>

</td>

<td>

{{ $order->created_at->format('d/m/Y') }}

</td>

<td class="text-center">
    <a href="{{ route('orders.show',$order) }}"
class="btn btn-detail">

👁 Detail

</a>

</td>

</tr>

@empty

<tr>

<td colspan="7" class="text-center py-5">

<div style="font-size:60px;">🧺</div>

<h5 class="mt-3">

Belum ada pesanan

</h5>

<p class="text-muted">

Pesanan pelanggan akan muncul di sini.

</p>

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@if(method_exists($orders,'links'))

<div class="mt-4">

{{ $orders->links() }}

</div>

@endif

</div>

</div>

</div>

@endsection