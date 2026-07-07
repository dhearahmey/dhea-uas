@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Tracking Pesanan #{{ $order->order_number }}</h3>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
                </div>
                <div class="card-body">
                    @if($order->trackings->count() > 0)
                        <div class="timeline">
                            @foreach($order->trackings as $tracking)
                                <div class="d-flex mb-4">
                                    <div class="me-3">
                                        <span class="badge bg-{{ $tracking->status == 'completed' ? 'success' : ($tracking->status == 'cancelled' ? 'danger' : 'info') }} p-2">
                                            {{ $tracking->status_label ?? $tracking->status }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0"><strong>{{ $tracking->description }}</strong></p>
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
        </div>
    </div>
</div>
@endsection