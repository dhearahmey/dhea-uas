@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Pesanan #{{ $order->order_number }}</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Informasi Pesanan</div>
                        <div class="card-body">
                            <p><strong>No. Order:</strong> {{ $order->order_number }}</p>
                            <p><strong>Paket:</strong> {{ $order->package->name }}</p>
                            <p><strong>Berat:</strong> {{ $order->weight }} kg</p>
                            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                            </p>
                            <p><strong>Tanggal Ambil:</strong> {{ $order->pickup_date->format('d/m/Y') }}</p>
                            @if($order->delivery_date)
                                <p><strong>Tanggal Selesai:</strong> {{ $order->delivery_date->format('d/m/Y') }}</p>
                            @endif
                            <p><strong>Catatan:</strong> {{ $order->note ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">Pembayaran</div>
                        <div class="card-body">
                            @if($order->payment)
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $order->payment->status == 'verified' ? 'success' : ($order->payment->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ $order->payment->status_label }}
                                    </span>
                                </p>
                                <p><strong>Metode:</strong> {{ strtoupper($order->payment->method) }}</p>
                                <p><strong>Jumlah:</strong> Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                                @if($order->payment->proof_image)
                                    <a href="{{ asset('storage/' . $order->payment->proof_image) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti</a>
                                @endif
                                @if($order->payment->status == 'rejected')
                                    <a href="{{ route('payments.create', $order) }}" class="btn btn-sm btn-warning">Upload Ulang</a>
                                @endif
                            @else
                                <p>Belum ada pembayaran</p>
                                @if($order->status == 'pending')
                                    <a href="{{ route('payments.create', $order) }}" class="btn btn-success">Upload Bukti Bayar</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Tracking Pesanan</div>
                <div class="card-body">
                    @if($order->trackings->count() > 0)
                        <div class="timeline">
                            @foreach($order->trackings as $tracking)
                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <span class="badge bg-{{ $tracking->status == 'completed' ? 'success' : ($tracking->status == 'cancelled' ? 'danger' : 'info') }} p-2">
                                            {{ $tracking->status_label ?? $tracking->status }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0">{{ $tracking->description }}</p>
                                        <small class="text-muted">{{ $tracking->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Belum ada tracking</p>
                    @endif
                </div>
            </div>

            @if(Auth::user()->isAdmin())
                <div class="card mt-3">
                    <div class="card-header">Admin Action</div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <select name="status" class="form-control">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Sudah Diambil</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection