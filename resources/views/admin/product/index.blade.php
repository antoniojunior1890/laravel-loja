{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Categoria')

{{--@section('content_header')--}}
{{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')
    {{--<p>Welcome to this beautiful admin panel.</p>--}}

    {{--@if(session('data'))--}}
        {{--<div class="alert alert-success" role="alert" id="alertMsg1">--}}
            {{--<strong>Sucesso!</strong> A categoria {{session('data')->nome}} foi atualizada com sucesso!--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
        {{--</div>--}}
    {{--@endif--}}


    @include('includes.alerts')

    <a href="{{route('product.create') }}"><i class="btn btn-lg btn-primary" style="margin-bottom: 10px;"  role="button">Adicionar</i> </a>



    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Produtos</h3>

            {{--<div class="well well-sm text-center"><h4>Quant.: {{$quant}} - Quant. Total: {{$total}}</h4></div>--}}
            {{--<h3 class="text-center"><span>Quant.: {{$quant}} - Quant. Total: {{$total}}</span></h3>--}}
            {{--<button type="button" class="btn btn-primary btn-block">Quant.: {{$quant}} - Quant. Total: {{$total}}</button>--}}
            <li class="list-group-item text-black text-center"><h4>Quant.: {{$quant}} - Total: {{$total}}</h4></li>
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-body text-center"><h5>Quant.: {{$quant}} - Quant. Total: {{$total}}</h5></div>--}}
            {{--</div>--}}
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
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                            <tr>
                                <td class="col-sm-1">{{$p->id}}</td>
                                <td class="col-sm-2">{{$p->name}}</td>
                                <td class="col-sm-3" style="max-width: 177px;"><span class="span-truncate">{{$p->description}}</span></td>
                                <td class="col-sm-1">{{$p->amount}} </td>
                                <td class="col-sm-1">{{$p->price}} </td>
                                <td class="col-sm-2">{{ !empty($p->category->name )? $p->category->name : '-'}} </td>
                                <td class="col-sm-2 text-center">
                                    <a href="{{route('product.show',['id' => $p->id]) }}"><i class="btn btn-primary fa fa-eye" role="button"></i> </a>
                                    <a href="{{route('product.edit',['id' => $p->id]) }}"><i class="btn btn-success fa fa-pencil" role="button"></i> </a>
                                    <a href="#"><i id="btnpagar" class="btn btn-danger fa fa-trash" data-idproduct = "{{$p->id}}"  data-toggle="modal" data-target="#modalExcluir"  role="button"></i> </a>
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
    <div class="modal fade" id="modalExcluir">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apagar Registro</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    Deseja apagar o produto?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="delete-btn" data-dismiss="modal">Apagar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')

@stop

@section('js')


    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>

    <script src="{{asset('js/close_alerts.js')}}"></script>

    <script>
        var id;

        $(document).on('click','#btnpagar', function () {
            id = $(this).data('idproduct');
        })

        $(document).ready(function () {

            $('#modalExcluir').focus()
                .on('click', '#delete-btn', function(){

                    var url = "{{route('product.destroy',['id' => '_id_'])}}".replace('_id_',id);


                    $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "html",
                        data: {
                            "_method": 'DELETE',
                            "_token": "{{csrf_token()}}",
                        },
                    }).done(function (data) {
                        location.reload();
                    }).fail(function () {
                        alert("Erro ao apagar registro.")
                    }).always(function () {
                    });
                });
        });
    </script>

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