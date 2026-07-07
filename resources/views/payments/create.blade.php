@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Upload Bukti Pembayaran</h3>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p><strong>Order #{{ $order->order_number }}</strong></p>
                        <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('payments.store', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="method" id="method" class="form-control @error('method') is-invalid @enderror" required>
                                <option value="">Pilih Metode</option>
                                <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ old('method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="qris" {{ old('method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                            </select>
                            @error('method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proof_image" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                            <input type="file" name="proof_image" id="proof_image" class="form-control @error('proof_image') is-invalid @enderror" 
                                   accept="image/*" required>
                            <small class="text-muted">Upload foto bukti pembayaran (max 2MB)</small>
                            @error('proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection