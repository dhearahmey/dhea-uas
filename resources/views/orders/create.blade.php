@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Buat Pesanan</h3>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="package_id" class="form-label">Pilih Paket <span class="text-danger">*</span></label>
                            <select name="package_id" id="package_id" class="form-control @error('package_id') is-invalid @enderror" required>
                                <option value="">Pilih Paket</option>
                                @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ request('package') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}/kg
                                </option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat (kg) <span class="text-danger">*</span></label>
                            <input type="number" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror" 
                                   step="0.1" min="0.5" value="{{ old('weight') }}" required>
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pickup_date" class="form-label">Tanggal Ambil <span class="text-danger">*</span></label>
                            <input type="date" name="pickup_date" id="pickup_date" class="form-control @error('pickup_date') is-invalid @enderror" 
                                   value="{{ old('pickup_date') }}" required>
                            @error('pickup_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" 
                                      rows="3">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection