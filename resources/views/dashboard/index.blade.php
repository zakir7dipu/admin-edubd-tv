@extends('layouts.master')
@section('title','Dashboard')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style type="text/css">

    body{
margin-top:20px;
background:#FAFAFA;
}
.order-card {
color: #fff;
}

.bg-c-blue {
background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
background: linear-gradient(45deg,#FF5370,#ff869a);
}


.card {
border-radius: 5px;
-webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
border: none;
margin-bottom: 30px;
-webkit-transition: all 0.3s ease-in-out;
transition: all 0.3s ease-in-out;
}

.card .card-block {
padding: 25px;
}

.order-card i {
font-size: 26px;
}

.f-left {
float: left;
}

.f-right {
float: right;
}
</style>
@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-home-lg-alt"></i> @yield('title')</h4>
    </div>
   
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Today Orders</h6>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>{{ $todayOrder }}</span></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Today Sales</h6>
                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span>{{ $todaySales }} TK.</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">This Month Orders</h6>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span>{{ $monthOrder }}</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">This Month Sales</h6>
                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span>{{ $thisMonthSales }} TK.</span></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Course</h6>
                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span>{{$courseCount}}</span></h2>
                </div>
            </div>
        </div>
        
        
	</div>

    <div class="row">
        <canvas id="line-chart" style="height: 300px; width: 100%;"></canvas>
    </div>
   
    <script>
        var labels = @json($lineChartLabels);
        var data = @json($lineChartData);
    
        var ctx = document.getElementById('line-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales',
                    data: data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection


@section('script')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>
@stop
