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

/* Supaya tombol bisa diklik */
.payment-banner>*{
    position:relative;
    z-index:2;
}

.payment-banner::before{
    content:'';
    position:absolute;
    width:170px;
    height:170px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    right:-40px;
    top:-50px;
    pointer-events:none;
}

.payment-banner::after{
    content:'';
    position:absolute;
    width:110px;
    height:110px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    left:-20px;
    bottom:-20px;
    pointer-events:none;
}

.payment-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.payment-header{
    background:#7BDFF2;
    color:white;
    padding:18px 25px;
}

.info-box{
    background:#F4FDFF;
    border-radius:15px;
    padding:18px;
    margin-bottom:20px;
}

.form-control,
.form-select{
    border-radius:15px;
}

.form-control:focus,
.form-select:focus{
    border-color:#55DDE0;
    box-shadow:0 0 0 .2rem rgba(85,221,224,.25);
}

.btn-bubble{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
    padding:10px 24px;
}

.btn-bubble:hover{
    background:#39CCD3;
    color:white;
}

</style>

<div class="container py-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="payment-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>💳 Upload Bukti Pembayaran</h2>

<p class="mb-0">

Upload bukti pembayaran pesananmu 🫧

</p>

</div>

<a
href="{{ route('orders.show',$order) }}"
class="btn btn-light rounded-pill">

⬅ Kembali

</a>

</div>

</div>

<div class="card payment-card">

<div class="payment-header">

<h4 class="mb-0">

🧾 Informasi Pembayaran

</h4>

</div>

<div class="card-body">

<div class="info-box">

<p><strong>Order</strong><br>

#{{ $order->order_number }}</p>

<p class="mb-0">

<strong>Total Pembayaran</strong><br>

<b class="text-primary">

Rp {{ number_format($order->total_price,0,',','.') }}

</b>

</p>

</div>

<form action="{{ route('payments.store',$order) }}"
method="POST"
enctype="multipart/form-data">

@csrf
<div class="mb-3">

<label for="method" class="form-label fw-bold">

💳 Metode Pembayaran <span class="text-danger">*</span>

</label>

<select
name="method"
id="method"
class="form-select @error('method') is-invalid @enderror"
required>

<option value="">-- Pilih Metode Pembayaran --</option>

<option value="cash" {{ old('method')=='cash' ? 'selected' : '' }}>
💵 Cash
</option>

<option value="transfer" {{ old('method')=='transfer' ? 'selected' : '' }}>
🏦 Transfer Bank
</option>

<option value="qris" {{ old('method')=='qris' ? 'selected' : '' }}>
📱 QRIS
</option>

</select>

@error('method')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

<div class="mb-4" id="proofDiv">

<label for="proof_image" class="form-label fw-bold">

🧾 Bukti Pembayaran <span class="text-danger">*</span>

</label>

<input
type="file"
name="proof_image"
id="proof_image"
accept="image/*"
class="form-control @error('proof_image') is-invalid @enderror">

<small class="text-muted">

Upload foto bukti pembayaran (maksimal 2 MB)

</small>

@error('proof_image')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>

<div class="d-flex gap-2">

<button
type="submit"
class="btn btn-bubble">

📤 Kirim Bukti

</button>

<a
href="{{ route('orders.show',$order) }}"
class="btn btn-outline-secondary rounded-pill">

Batal

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded',function(){

const method=document.getElementById('method');

const proof=document.getElementById('proof_image');

const proofDiv=document.getElementById('proofDiv');

function toggleProof(){

if(method.value==='cash'){

proof.required=false;

proof.value='';

proofDiv.style.display='none';

}else{

proof.required=true;

proofDiv.style.display='block';

}

}

toggleProof();

method.addEventListener('change',toggleProof);

});

</script>

@endsection