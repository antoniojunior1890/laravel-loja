@extends('adminlte::page')

@section('title', 'Carrinho')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Produtos do Carrinho</h3>
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
                    <li>Informe nome do cliente</li>
                    {{--@foreach($errors->all() as $error)--}}
                        {{--<li>{{ $error }}</li>--}}
                    {{--@endforeach--}}
                </ul>
            </div>

            @include('includes.alerts')

            {{ Form::open(array('class' => 'form-horizontal')) }}

                <div class="form-inline col-lg-12">

                    <div class="form-group pull-right">
{{--                        {{Form::label('product', 'Buscar :',['class' => 'control-label '])}}--}}
                        <span>Buscar: </span>
                        {{Form::text('search_name',null, array('class' => 'form-control','placeholder'=>'Informe o produto.','id'=>'search_name')) }}
                    </div>

                    <div class="form-group ">
                        {{Form::label('name_client', 'Cliente :',['class' => 'control-label'])}}
                        @if(Session::has('cart'))
                            {{Form::text('name_client',Session::get('cart')->getNameClient(),['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Cliente'])}}
                        @else
                            {{Form::text('name_client',null,['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Cliente'])}}
                        @endif
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
                        <th>Quant. Estoque</th>
                        <th>Quant. Pedido</th>
                        <th>Sub. Total</th>
                        <th>Remover</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td class="col-sm-1">{{$p['item']->id}}</td>
                                <td class="col-sm-2">{{$p['item']->name}}</td>
                                <td class="col-sm-2">R$ {{$p['item']->price}}</td>
                                <td class="col-sm-2">{{$p['item']->stock->amount}}</td>
                                <td class="col-sm-2">
                                    <a href="{{route('remove.cart',$p['item']->id)}}" ><i class="fa fa-minus-circle"></i></a>
                                    {{$p['qtd']}}
                                    <a href="{{route('add.cart',$p['item']->id)}}" ><i class="fa fa-plus-circle"></i></a>
                                </td>
                                <td class="col-sm-2">R$ {{$p['item']->price * $p['qtd']}}</td>
                                <td class="col-sm-2">
                                    <a href="{{route('remove.product.cart',$p['item']->id) }}"><i class="btn btn-primary" role="button" >remover</i></a>
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
                <a class="btn btn-primary" id="btnSalvarPedido" href="#" >Salvar</a>
                <a class="btn btn-primary"  data-toggle="modal" id="btnpagar"  >Pagar</a>
            </div>
            <b><h4>Total: R$ {{$cart->total()}}</h4></b>
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
                    <p>Deseja esvaziar o carrinho?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="delete-btn" data-dismiss="modal">Limpar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Forma de Pagamento -->
    <div class="modal fade" id="modalForPag" tabindex="-1" role="dialog" aria-labelledby="modalForPagModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalForPagModalLabel">Forma de Pagamento</h5>

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
@stop

@section('js')

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>

        //Pagar carrinho
        $(document).on('click','#btnpagar', function () {

            var name_client = document.getElementById('name_client').value;
            if (name_client == "") {
                $('.alert-clint').show();
            }
            else {
                $('#modalForPag').modal('show');
            }


            $('#modalForPag').focus()
                .on('click', '#pay-btn', function () {

                    var var_option = $("input[name='optionsRadios']:checked").val();

                    var url = "{{route('save.order')}}";
                    $.get(url, { name_client: name_client, payment_method: var_option, status : 2}, function (data) {
                        // console.log(data);
                        // return false;
                        location.href="{{route('cart')}}";
                    });
                });

        });





        $( function() {

            var path = "{{ route('product.autocomplete') }}";

            var _id;


            $( "#search_name" ).autocomplete({
                source: path,
                select: function (event, ui) {
                    // console.log(ui.item);
                    // console.log(ui.item.email);
                    $('#search_name').val(ui.item.label);
                    // $('#sender_id').val(ui.item.id);
                    _id = ui.item.id;

                    // console.log(_id);

                    addCard(_id);
                    return false;
                }
            });
        } );


        function addCard(_id)
        {
            var url = "{{route('add.cart',['id' => '_id_'])}}".replace('_id_',_id);

            $.get(url, function(data){
                location.href="{{route('cart')}}";
                // alert("Data: " + data);
                // console.log(data);
                // location.reload();
                // location.href=data;
            });

        }

        // Pegar nome cliente e Salvar pedido
        $(document).on('click','#btnSalvarPedido', function () {
            // id = $(this).data('idorder');

            var name_client = document.getElementById('name_client').value;
            if(name_client == "") {
                $('.alert-clint').show();
            }
            else {

                var url = "{{route('save.order')}}";
                // console.log(url);


                $.get(url, {  name_client: name_client, payment_method: null, status : 1}, function (data) {
                    // location.href=data;
                    // console.log(data);
                    // return false;
                    // location.reload();
                    location.href="{{route('cart')}}";
                });
            }

            // $.get(url, function (data) {
            //     console.log(data);
            //     // location.reload();
            // });
        });


         // Limpar Carrinho
        $('#modalExemplo').focus()
            .on('click', '#delete-btn', function(){
                // $form.submit();
                var url = "{{route('empty.cart')}}";
                $.get(url, function(data){
                    // console.log(data);
                    // location.reload();
                    location.href="{{route('cart')}}";
                });
            });

    </script>

    <script src="{{asset('js/close_alerts.js')}}"></script>
@stop
