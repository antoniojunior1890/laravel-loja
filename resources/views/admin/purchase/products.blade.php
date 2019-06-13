@extends('adminlte::page')

@section('title', 'Produto')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Detalhe da Compra - <b>{{$purchase->name_salesman}}</b></h3>
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
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço Unit.</th>
                        <th>Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="col-sm-1">{{$product->id}}</td>
                            <td class="col-sm-2">{{$product->name}}</td>
                            <td class="col-sm-3" style="max-width: 177px;"><span class="span-truncate">{{$product->description}}</span></td>
                            <td class="col-sm-2">{{ !empty($product->category->name )? $product->category->name : '-'}} </td>
                            <td class="col-sm-1">{{$product->pivot->qtd}} </td>
                            <td class="col-sm-1">R$ {{$product->pivot->price}} </td>
                            <td class="col-sm-1">R$ {{$product->pivot->price * $product->pivot->qtd}} </td>
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
            </div>
            <b><h4>Total: R$ {{$totalPrice}}</h4></b>
        </div>
    </div>
@stop




