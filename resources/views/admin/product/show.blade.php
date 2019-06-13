@extends('adminlte::page')

@section('title', 'Categoria')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')
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
                    <b>Nome:</b> {{$data->name }}
                </li>
                <li>
                    <b>Descrição:</b> {{$data->description }}
                </li>
                <li>
                    <b>Valor:</b> R$ {{$data->price}}
                </li>
                <li>
                    <b>Quantidade em estoque:</b> {{$data->amount}}
                </li>
                <li>
                    <b>Categoria:</b> {{!empty($data->category->name )? $data->category->name : '-'}}
                </li>
            </ul>
        </div>

    </div>
@stop




