{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Categoria')

@section('content')


    @include('includes.alerts')

    <a href="{{route('category.create') }}"><i class="btn btn-primary" style="margin-bottom: 10px;"  role="button">Adicionar</i> </a>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Categorias</h3>
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
                        <th>Ações</th>
                        {{--<th>Editar</th>--}}
                        {{--<th>Remover</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $p)
                            <tr>
                                <td class="col-sm-1">{{$p->id}}</td>
                                <td class="col-sm-3">{{$p->name}}</td>
                                <td class="col-sm-4">{{$p->description}} </td>
                                <td class="col-sm-2 text-center">
                                    <a href="{{route('category.show',['id' => $p->id]) }}"><i class="btn btn-primary fa fa-eye" role="button"></i> </a>
                                    <a href="{{route('category.edit',['id' => $p->id]) }}"><i class="btn btn-success fa fa-pencil" role="button"></i> </a>
                                    <a href="#"><i id="btnpagar" class="btn btn-danger fa fa-trash" data-idcategory = "{{$p->id}}"  data-toggle="modal" data-target="#modalExcluir"  role="button"></i> </a>
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="4">Nenhum registro encontrado</td>
                        @endforelse
                    </tbody>
                    {{--<tfoot>--}}
                    {{--<tr>--}}
                        {{--<th>Nome</th>--}}
                        {{--<th>Descrição</th>--}}
                        {{--<th>Visualizar</th>--}}
                        {{--<th>Editar</th>--}}
                        {{--<th>Remover</th>--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
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
                    Deseja apagar a categoria?
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

    <script src="{{asset('js/close_alerts.js')}}"></script>
    <script>

        var id;

        $(document).on('click','#btnpagar', function () {
            id = $(this).data('idcategory');
        })

        $(document).ready(function () {

            $('#modalExcluir').focus()
                .on('click', '#delete-btn', function(){

                    var url = "{{route('category.destroy',['id' => '_id_'])}}".replace('_id_',id);


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
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions:{
                            columns:[0,1,2]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions:{
                            columns:[0,1,2]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions:{
                            columns:[0,1,2]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions:{
                            columns:[0,1,2]
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