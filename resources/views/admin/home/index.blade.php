@extends('adminlte::page')

{{--@section('title', 'Home Dashboard')--}}

@section('content_header')
    {{--<h1>Dashboard</h1>--}}
@stop

@section('content')

    @include('includes.alerts')

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Compras e Vendas</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
        {{--<div class="col-lg-3 col-xs-6">--}}
        <!-- small box -->



            {{--<div class="small-box bg-green">--}}
                {{--<div class="inner">--}}
                    {{--<h3>R$ 15</h3>--}}
                    {{--<p>Vendas no dia</p>--}}
                {{--</div>--}}
                {{--<div class="icon">--}}
                    {{--<i class="ion ion-cash"></i>--}}
                {{--</div>--}}
                {{--<a href="{{route('admin.historic')}}" class="small-box-footer">Histórico<i class="fa fa-arrow-circle-right"></i></a>--}}
            {{--</div>--}}


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$purchasesDay}}</h3>

                        <p>Compras Dia</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('purchases.index')}}" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$purchasesMonth}}</h3>

                        <p>Compras Mês</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('purchases.index')}}" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$paidOrdersDay}}</h3>

                        <p>Vendas Dia</p>
                    </div>
                    <div class="icon">
                        {{--<i class="ion ion-person-add"></i>--}}
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a href="{{route('paid.orders')}}" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$paidOrdersMonth}}</h3>

                        <p>Vendas Mês</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cart"></i>
                    </div>
                    <a href="{{route('paid.orders')}}" class="small-box-footer">Mais informações <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Vendas Diárias - Semana</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            </div>
        </div>
        <div class="box-body">
            <canvas id="myChart2" width="400" height="100"></canvas>
        </div>
    </div>


    <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Vendas Diárias - Mês</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                </div>
            </div>
            <div class="box-body">
                <canvas id="myChart" width="400" height="100"></canvas>
            </div>
        </div>
@stop

@section('js')

    <script>

        // var ctx = document.getElementById('myChart2').getContext('2d');
        // var myPieChart = new Chart(ctx, {
        //     type: 'pie',
        //     data: [12, 19, 3, 5, 2, 3],
        // });



        $(document).ready(function () {
            // getDaysArray();
            // var data = getSalesArray();

            getSalesWeekArray();

            getSalesMonthArray();
            

            

        });

        function getSalesWeekArray() {
            var url = "{{route('sales.week')}}";

            $.get(url, function (data) {
            }).done(function (data) {

                var salesArray = [];

                for(var i in data) {
                    salesArray.push(data[i]);
                }

                createChartWeek(salesArray);
            });
        }

        function getSalesMonthArray() {

            var url = "{{route('sales.month')}}";

            $.get(url, function (data) {
            }).done(function (data) {

                var salesArray = [];

                for(var i in data) {
                    salesArray.push(data[i]);
                }

                createChart(salesArray);
            });
        }

        function createChart(salesArray) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    labels: getDaysArray(),
                    datasets: [{
                        label: 'Vendas diárias (mês)',
                        data: salesArray,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        function createChartWeek(salesArray) {
            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Dom','Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    datasets: [{
                        label: 'Vendas diárias (semana)',
                        data: salesArray,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

        function getDaysArray() {
            var i;
            var data = new Date();
            daysArray = [];


            for (i = 1; i <= data.getDate(); i++) {
                daysArray.push((i));
            }

            return daysArray;
        }

    </script>
@stop