@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content')

    @include('includes.alerts')

    <a href="{{route('cart') }}"><i class="btn btn-primary" style="margin-bottom: 10px"  role="button">Novo Pedido</i> </a>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Pedidos Aguardando Pagamento</h3>
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
                        <th>Data</th>
                        <th>Situação</th>
                        {{--<th>Forma de Pagamento</th>--}}
                        <th>Visualizar</th>
                        <th>Pagar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="col-sm-1">{{$order->id}}</td>
                            <td class="col-sm-4">{{$order->name_client}}</td>
                            <td class="col-sm-2">{{$order->date}}</td>
                            <td class="col-sm-2">{{$order->getStatus($order->status)}}</td>
                            {{--<td class="col-sm-2">--}}
                                {{--@isset($order->payment_method)--}}
                                    {{--{{$order->getPaymentMethod($order->payment_method)}}--}}
                                {{--@else--}}
                                    {{-----}}
                                {{--@endisset--}}
                            {{--</td>--}}
{{--                            <td class="col-sm-2"><a href="{{route('details.order',$order->id)}}">Visualizar</a></td>--}}
                            <td class="col-sm-2"><a href="{{route('cart.test',$order->id)}}"><i class="btn btn-primary fa fa-eye" role="button"></i></a></td>
                            {{--<td class="col-sm-2"><a href="{{route('pay.order',$order->id)}}">Pagar</a></td>--}}
                            <td class="col-sm-2"><a class="btn btn-primary" id="btnpagar" data-idorder = "{{$order->id}}" data-toggle="modal" data-target="#modalExemplo">Pagar</a></td>
                            {{--<td class="col-sm-2"><a class="btn btn-primary" id="btnteste" data-idorder = "CASA">Pagar</a></td>--}}
                        </tr>
                    @empty
                        <td class="text-center" colspan="6">Nenhum registro encontrado</td>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forma de Pagamento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
                                Avista
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
                                Boleto
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios3" value="3">
                                Cartão
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="pay-btn" data-dismiss="modal">Pagar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')

@stop

@section('js')

    <script>
        var id;

        $(document).on('click','#btnpagar', function () {
            id = $(this).data('idorder');
        })

        $('#modalExemplo').focus()
            .on('click', '#pay-btn', function(){
                var var_option = $("input[name='optionsRadios']:checked").val();

                if(var_option != null) {
                    var url = "{{route('pay.order.existing',['id' => '_id_'])}}".replace('_id_',id);
                    // alert($(this).attr('idorder'));
                    // console.log(id);
                    // console.log(var_option);
                    $.get(url, { payment_method: var_option }, function (data) {
                        location.reload();
                        // console.log(data);
                        // return false;
                    });
                }
            });


        $(document).ready(function () {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions:{
                            columns:[0,1,2,3]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:{
                            columns:[0,1,2,3]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions:{
                            columns:[0,1,2,3]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions:{
                            columns:[0,1,2,3]
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


