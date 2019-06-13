@extends('adminlte::page')

@section('title', 'Produto')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}


@section('content')

    <a href="{{route('stock.index') }}"><i class="btn btn-primary" style="margin-bottom: 10px;"  role="button">Voltar</i> </a>
    
    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Detalhes do produto</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            </div>
        </div>

        <div class="box-body">
            <ul>
                <li>
                    <b>Nome:</b> {{$stock->product->name }}
                </li>
                <li>
                    <b>Descrição:</b> {{$stock->product->description }}
                </li>
                <li>
                    <b>Valor:</b> R$ {{$stock->product->price}}
                </li>
                <li>
                    <b>Quantidade em estoque:</b> {{$stock->amount}}
                </li>
                <li>
                    <b>Categoria:</b> {{!empty($stock->product->category->name )? $stock->product->category->name : '-'}}
                </li>
            </ul>
        </div>

    </div>
@stop




