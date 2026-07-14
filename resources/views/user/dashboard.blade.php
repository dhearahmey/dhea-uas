@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.dashboard-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:35px;
    box-shadow:0 15px 30px rgba(0,0,0,.08);
    margin-bottom:30px;
    position:relative;
    overflow:hidden;
}

.dashboard-banner::before{
    content:'';
    position:absolute;
    width:180px;
    height:180px;
    background:rgba(255,255,255,.15);
    border-radius:50%;
    top:-60px;
    right:-40px;
}

.dashboard-banner::after{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    background:rgba(255,255,255,.2);
    border-radius:50%;
    bottom:-35px;
    left:-20px;
}

.stat-card{
    border:none;
    border-radius:22px;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.blue{
    background:linear-gradient(135deg,#55DDE0,#7BDFF2);
}

.orange{
    background:linear-gradient(135deg,#FFD166,#F4A261);
}

.green{
    background:linear-gradient(135deg,#80ED99,#38B000);
}

.stat-card h2{
    font-size:40px;
    font-weight:bold;
}

.order-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.order-header{
    background:#7BDFF2;
    color:white;
    padding:18px 25px;
}

.table thead{
    background:#F1FCFF;
}

.table thead th{
    color:#2A6F97;
    border:none;
}

.table tbody tr:hover{
    background:#F8FEFF;
}

.btn-bubble{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:50px;
    padding:8px 20px;
}

.btn-bubble:hover{
    background:#3CCED3;
    color:white;
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

</style>

<div class="container py-4">

@if(session('success'))
<div class="alert alert-success rounded-4 shadow-sm">
{{ session('success') }}
</div>
@endif

<div class="dashboard-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🫧 Bubble Wash Laundry</h2>

<p class="mb-0">

Halo <strong>{{ Auth::user()->name }}</strong> 👋<br>

Semoga harimu sebersih cucianmu ✨

</p>

</div>

<a href="{{ route('orders.create') }}" class="btn btn-light rounded-pill px-4">

🧺 Buat Pesanan

</a>

</div>

</div>

<div class="row mb-4">

<div class="col-md-4">

<div class="card stat-card blue">

<div class="card-body">

<h5>🧺 Total Pesanan</h5>

<h2>{{ $totalOrders ?? 0 }}</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat-card orange">

<div class="card-body">

<h5>🫧 Sedang Diproses</h5>

<h2>{{ $activeOrders ?? 0 }}</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat-card green">

<div class="card-body">

<h5>✨ Selesai</h5>

<h2>{{ $orders->where('status','completed')->count() }}</h2>

</div>

</div>

</div>

</div>

<div class="card order-card">

<div class="order-header">

<h4 class="mb-0">

📦 Pesanan Terbaru

</h4>

</div>

<div class="card-body">

@if($orders->count()>0)

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No Order</th>

<th>Paket</th>

<th>Berat</th>

<th>Total</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($orders as $order)
<tr>

    <td>
        <strong>{{ $order->order_number }}</strong><br>
        <small class="text-muted">
            {{ $order->created_at->format('d M Y') }}
        </small>
    </td>

    <td>
        🧺 {{ $order->package->name }}
    </td>

    <td>
        {{ $order->weight }} kg
    </td>

    <td class="fw-bold text-primary">
        Rp {{ number_format($order->total_price,0,',','.') }}
    </td>

    <td>

        @if($order->status=='pending')

            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                ⏳ {{ $order->status_label }}
            </span>

        @elseif($order->status=='processing')

            <span class="badge rounded-pill bg-info text-dark px-3 py-2">
                🫧 {{ $order->status_label }}
            </span>

        @elseif($order->status=='ready')

            <span class="badge rounded-pill bg-primary px-3 py-2">
                📦 {{ $order->status_label }}
            </span>

        @elseif($order->status=='completed')

            <span class="badge rounded-pill bg-success px-3 py-2">
                ✨ {{ $order->status_label }}
            </span>

        @elseif($order->status=='cancelled')

            <span class="badge rounded-pill bg-danger px-3 py-2">
                ❌ {{ $order->status_label }}
            </span>

        @else

            <span class="badge rounded-pill bg-secondary px-3 py-2">
                {{ $order->status_label }}
            </span>

        @endif

    </td>

    <td>

        <a href="{{ route('orders.show',$order) }}"
           class="btn btn-detail btn-sm">

            👀 Detail

        </a>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

@else

<div class="text-center py-5">

<div style="font-size:70px;">
🫧
</div>

<h3 class="mt-3">

Belum Ada Pesanan

</h3>

<p class="text-muted">

Yuk buat pesanan laundry pertamamu!

</p>

<a href="{{ route('orders.create') }}"
class="btn btn-bubble">

🧺 Buat Pesanan

</a>

</div>

@endif

</div>

</div>

</div>

@endsection