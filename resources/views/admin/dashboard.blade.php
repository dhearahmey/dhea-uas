@extends('layouts.app')

@section('content')

<style>

body{
background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.dashboard-title{
font-weight:700;
color:#1596B8;
margin-bottom:25px;
}

.stat-card{
border:none;
border-radius:25px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
}

.stat-card:hover{
transform:translateY(-6px);
}

.stat-card .card-body{
padding:25px;
}

.icon-circle{
width:65px;
height:65px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:28px;
background:rgba(255,255,255,.25);
margin-bottom:15px;
}

.card-total{
background:linear-gradient(135deg,#7BDFF2,#55DDE0);
color:white;
}

.card-pending{
background:linear-gradient(135deg,#FFD166,#F4A261);
color:white;
}

.card-process{
background:linear-gradient(135deg,#6EC6FF,#3A86FF);
color:white;
}

.card-income{
background:linear-gradient(135deg,#80ED99,#38B000);
color:white;
}

.chart-card{
border:none;
border-radius:25px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.chart-header{
background:#7BDFF2;
color:white;
padding:18px 25px;
font-weight:600;
font-size:20px;
}

</style>

<div class="container py-4">

<h2 class="dashboard-title">
🫧 Dashboard Admin Laundry
</h2>

<div class="row g-4 mb-4">

<div class="col-lg-3 col-md-6">

<div class="card stat-card card-total">

<div class="card-body">

<div class="icon-circle">
🧺
</div>

<h6>Total Pesanan</h6>

<h2>{{ $totalOrders }}</h2>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card stat-card card-pending">

<div class="card-body">

<div class="icon-circle">
⏳
</div>

<h6>Pending</h6>

<h2>{{ $pendingOrders }}</h2>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card stat-card card-process">

<div class="card-body">

<div class="icon-circle">
⚙️
</div>

<h6>Diproses</h6>

<h2>{{ $processingOrders }}</h2>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card stat-card card-income">

<div class="card-body">

<div class="icon-circle">
💰
</div>

<h6>Pendapatan</h6>

<h4>

Rp {{ number_format($totalRevenue,0,',','.') }}

</h4>

</div>

</div>

</div>

</div>

<div class="card chart-card">

<div class="chart-header">

📊 Statistik 7 Hari Terakhir

</div>

<div class="card-body">

<canvas id="orderChart" height="100"></canvas>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('orderChart').getContext('2d');

new Chart(ctx,{

type:'bar',

data:{

labels:{!! json_encode(array_column($chartData,'date')) !!},

datasets:[{

label:'Jumlah Order',

data:{!! json_encode(array_column($chartData,'total')) !!},

backgroundColor:[
'#7BDFF2',
'#55DDE0',
'#6EC6FF',
'#80ED99',
'#FFD166',
'#A29BFE',
'#74C69D'
],

borderColor:'#55DDE0',

borderWidth:2,

borderRadius:12,

borderSkipped:false

}]

},

options:{

responsive:true,

plugins:{

legend:{
display:false
},

tooltip:{
backgroundColor:'#ffffff',
titleColor:'#1596B8',
bodyColor:'#555',
borderColor:'#7BDFF2',
borderWidth:1
}

},

scales:{

y:{

beginAtZero:true,

grid:{
color:'rgba(0,0,0,.05)'
},

ticks:{
stepSize:1
}

},

x:{

grid:{
display:false
}}
}}
});

</script>

@endsection