{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Categoria')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')

        @include('includes.alerts')

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Categoria</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                </div>
            </div>

            <div class="box-body">

                @isset($data)
                    {{ Form::model($data, array('route' => array('category.update', $data->id),'method' => 'PUT' ,'class' => 'form'))}}
                @else
                    {{ Form::open(array('route' => 'category.store','class' => 'form')) }}
                @endisset

                <div class="form-row">
                    <div class="form-group col-lg-6">
                        {{Form::label('name', 'Nome',['class' => 'control-label'])}}
                        {{Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Nome'])}}
                    </div>
                    <div class="form-group col-lg-6">
                        {{Form::label('description', 'Descrição',['class' => 'control-label'])}}
                        {{Form::text('description',null,['class' => 'form-control', 'placeholder' => 'Descrição'])}}
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <div class="col-lg-offset-2">
                        {{Form::submit('Salvar',['class' => 'btn btn-primary pull-right'])}}
                    </div>
                </div>
                {{ Form::close() }}
            </div>

        </div>

@stop

@section('css')


@stop

@section('js')

    <script src="{{asset('js/close_alerts.js')}}"></script>
@stop