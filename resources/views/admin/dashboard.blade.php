@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin Laundry</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Total Pesanan</h5>
                    <h2>{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Pending</h5>
                    <h2>{{ $pendingOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Diproses</h5>
                    <h2>{{ $processingOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Pendapatan</h5>
                    <h2>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart sederhana -->
    <div class="card">
        <div class="card-header">Statistik 7 Hari Terakhir</div>
        <div class="card-body">
            <canvas id="orderChart" height="100"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($chartData, 'date')) !!},
            datasets: [{
                label: 'Jumlah Order',
                data: {!! json_encode(array_column($chartData, 'total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
@endsection