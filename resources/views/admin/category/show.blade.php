@extends('adminlte::page')

@section('title', 'Categoria')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')

    <a href="{{route('category.index') }}"><i class="btn btn-primary" style="margin-bottom: 10px;"  role="button">Voltar</i> </a>

    <div class="box box-info">
        <div class="box-header with-border">
                <h3 class="box-title">Detalhes da categoria</h3>
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
            </ul>
        </div>

    </div>
@stop




