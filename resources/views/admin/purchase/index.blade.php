{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Compras')

@section('content')

    @include('includes.alerts')

    <a href="{{route('purchases.create') }}"><i class="btn btn-primary" style="margin-bottom: 10px;"  role="button">Nova Compra</i> </a>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Compras Realizadas</h3>

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
                        <th>Nome Vendedor</th>
                        <th>Status</th>
                        <th>Forma de Pagamento</th>
                        <th>Data</th>
                        <th>Visualizar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td class="col-sm-1">{{$purchase->id}}</td>
                            <td class="col-sm-2">{{$purchase->name_salesman}}</td>
                            <td class="col-sm-2">{{$purchase->getStatus($purchase->status)}} </td>
                            <td class="col-sm-1">{{$purchase->getPaymentMethod($purchase->payment_method)}} </td>
                            <td class="col-sm-1">{{$purchase->date}} </td>
                            <td class="col-sm-1">
                                <a href="{{route('purchases.products',['id' => $purchase->id]) }}"><i class="btn btn-primary fa fa-eye" role="button"></i> </a>
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="7">Nenhum registro encontrado</td>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('css')

@stop

@section('js')

    <script src="{{asset('js/close_alerts.js')}}"></script>

    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions:{
                            columns:[0,1,2,3,4]
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