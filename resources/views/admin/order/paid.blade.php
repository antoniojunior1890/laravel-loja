@extends('adminlte::page')

@section('title', 'Pedido')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')

    @include('includes.alerts')

    <a href="{{route('cart') }}"><i class="btn btn-primary" style="margin-bottom: 10px"  role="button">Nova Venda</i> </a>

    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Vendas Realizadas</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="example" class="table table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Situação</th>
                        <th>Data Pedido</th>
                        <th>Data Pagamento</th>
                        <th>Forma de Pagamento</th>
                        <th>Visualizar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="col-sm-1">{{$order->id}}</td>
                            <td class="col-sm-4">{{$order->name_client}}</td>
                            <td class="col-sm-2">{{$order->getStatus($order->status)}}</td>
                            <td class="col-sm-2">{{$order->date}}</td>
                            <td class="col-sm-2">{{$order->date_refresh_status}}</td>
                            <td class="col-sm-2">{{$order->getPaymentMethod($order->payment_method)}}</td>
                            <td class="col-sm-2">
                                <a href="{{route('details.order',['id' => $order->id]) }}"><i class="btn btn-primary fa fa-eye" role="button"></i> </a>
                            </td>
                            {{--<td class="col-sm-2">--}}
                            {{--@isset($order->payment_method)--}}
                            {{--@else--}}
                            {{-----}}
                            {{--@endisset--}}
                            {{--</td>--}}
                        </tr>
                    @empty
                        <td class="text-center" colspan="7">Nenhum registro encontrado</td>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                {{--                <a class="btn btn-primary"  href="{{route('place.order')}}" >Finalizar Compra</a>--}}
            </div>
        </div>

    </div>
@stop


@section('js')

    <script>
        
        $(document).ready(function () {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4,5]
                        }
                    }
                    // 'pdfHtml5'
                ],
                "language":{
                    "lengthMenu":"Exibir _MENU_ registros por página",
                    "zeroRecords":"Nenhum registro encontrado",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty":"Nenhum registro disponível",
                    "infoFiltered":"(filtrado total de _MAX_ registros)",
                    "search":"Buscar:",
                    "paginate":{
                        "first":"Primeiro",
                        "last":"Último",
                        "previous":"Anterior",
                        "next":"Próximo"

                    }
                }
            });

        });

    </script>
@stop




