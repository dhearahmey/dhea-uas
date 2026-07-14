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
    position:relative;
    overflow:hidden;
    box-shadow:0 12px 25px rgba(0,0,0,.08);
}

.page-banner::before{
    content:'';
    width:170px;
    height:170px;
    background:rgba(255,255,255,.15);
    border-radius:50%;
    position:absolute;
    right:-40px;
    top:-50px;
}

.page-banner::after{
    content:'';
    width:110px;
    height:110px;
    background:rgba(255,255,255,.18);
    border-radius:50%;
    position:absolute;
    left:-20px;
    bottom:-20px;
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
    padding:8px 22px;
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

<div class="page-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🧺 Pesanan Saya</h2>

<p class="mb-0">

Lihat status dan riwayat laundry kamu dengan mudah 🫧

</p>

</div>

<a href="{{ route('orders.create') }}" class="btn btn-light rounded-pill px-4">

➕ Buat Pesanan Baru

</a>

</div>

</div>

<div class="card order-card">

<div class="order-header">

<h4 class="mb-0">

📦 Daftar Pesanan

</h4>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No Order</th>

<th>Paket</th>

<th>Berat</th>

<th>Total</th>

<th>Status</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($orders as $order)
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

        {{ $order->created_at->format('d/m/Y') }}

    </td>

    <td>

        <a href="{{ route('orders.show',$order) }}"
           class="btn btn-detail btn-sm">

            👀 Detail

        </a>

        @if($order->status=='pending')

        <form action="{{ route('orders.destroy',$order) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-danger btn-sm rounded-pill"
                    onclick="return confirm('Yakin ingin membatalkan pesanan?')">

                ❌ Batal

            </button>

        </form>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="7">

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

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4 d-flex justify-content-center">

    {{ $orders->links() }}

</div>

</div>

</div>

</div>

@endsection