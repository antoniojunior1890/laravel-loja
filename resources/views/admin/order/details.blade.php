@extends('adminlte::page')

@section('title', 'Venda')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Venda - <b>{{$order->name_client}}</b></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">

            @include('includes.alerts')

            <div class="table-responsive">
                <table id="example" class="table table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Sub. Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td class="col-sm-1">{{$p->id}}</td>
                            <td class="col-sm-4">{{$p->name}}</td>
                            <td class="col-sm-2">{{$p->pivot->qtd}}</td>
                            <td class="col-sm-2">R$ {{$p->price}}</td>
                            <td class="col-sm-2">R$ {{$p->pivot->price * $p->pivot->qtd }}</td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="5">Nenhum registro encontrado</td>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
            </div>
            <b><h4>Total: R$ {{$order->getTotalOrder()}}</h4></b>
        </div>
    </div>


@stop

@section('js')

    <script src="{{asset('js/close_alerts.js')}}"></script>
@stop
