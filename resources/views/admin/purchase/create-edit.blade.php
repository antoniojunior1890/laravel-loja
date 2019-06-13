{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Compra')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')

        @include('includes.alerts')

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Compra</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                </div>
            </div>

            <div class="box-body">

                <div style="display: none" class="alert alert-clint alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        <li>Informe nome do vendedor</li>
                    </ul>
                </div>

                {{ Form::open(array('class' => 'form-horizontal')) }}

                <div class="form-inline col-lg-12">

                    <div class="form-group pull-right">
                        {{--                        {{Form::label('product', 'Buscar :',['class' => 'control-label '])}}--}}
                        <span>Buscar: </span>
                        {{Form::text('search_name',null, array('class' => 'form-control','placeholder'=>'Informe o produto.','id'=>'search_name')) }}
                    </div>

                    <div class="form-group ">
                        {{Form::label('name_salesman', 'Cliente :',['class' => 'control-label'])}}
                        {{Form::text('name_salesman',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Vendedor'])}}
                    </div>
                </div>

                {{ Form::close() }}

            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table id="example" class="table table-hover table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Sub. Total</th>
                            <th>Operação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td class="col-sm-1">{{$p['item']->id}}</td>
                                <td class="col-sm-4">{{$p['item']->name}}</td>
                                <td class="col-sm-4">R$ {{$p['item']->price}}</td>
                                <td class="col-sm-1">
                                    <a href="{{route('remove.cart.purchase',$p['item']->id)}}" ><i class="fa fa-minus-circle"></i></a>
                                    {{$p['qtd']}}
                                    <a href="{{route('add.cart.purchase',$p['item']->id)}}" ><i class="fa fa-plus-circle"></i></a>
                                </td>
                                <td class="col-sm-1">R$ {{$p['item']->price * $p['qtd']}}</td>
                                <td class="col-sm-1">
                                    <a href="{{route('remove.product.cart.purchase',$p['item']->id) }}"><i class="btn btn-primary" role="button" >remover</i></a>
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="6">Nenhum registro encontrado</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#modalExemplo" >Limpar</a>
                    <a class="btn btn-primary" id="btnSalvarCompra" href="#" >Salvar</a>
                </div>
            </div>
        </div>

        <!-- Modal Limpar Carrinho -->
        <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Esvaziar Carrinho</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja limpar a lista?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="delete-btn" data-dismiss="modal">Limpar</button>
                    </div>
                </div>
            </div>
        </div>

@stop

@section('css')

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
@stop

@section('js')
    <script src="{{asset('js/close_alerts.js')}}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $( function() {

            var path = "{{ route('purchases.autocomplete') }}";

            var _id;


            $( "#search_name" ).autocomplete({
                source: path,
                select: function (event, ui) {
                    $('#search_name').val(ui.item.label);
                    _id = ui.item.id;
                    addCart(_id);
                    return false;
                }
            });
        } );

        function addCart(_id)
        {
            var url = "{{route('add.cart.purchase',['id' => '_id_'])}}".replace('_id_',_id);

            $.get(url, function(data){
                location.href="{{route('purchases.create')}}";
            });

        }

        // Limpar lista
        $('#modalExemplo').focus()
            .on('click', '#delete-btn', function(){
                var url = "{{route('empty.cart.purchase')}}";
                $.get(url, function(data){

                    location.href="{{route('purchases.create')}}";
            });
        });


        // Pegar nome cliente e Salvar pedido
        $(document).on('click','#btnSalvarCompra', function () {

            var name_salesman = document.getElementById('name_salesman').value;
            if(name_salesman == "") {
                $('.alert-clint').show();
            }
            else {

                var url = "{{route('save.purchase')}}";

                $.get(url, {  name_salesman: name_salesman, }, function (data) {
                    // console.log(data);
                    // return false;
                    location.reload();
                });
            }

        });
    </script>
@stop