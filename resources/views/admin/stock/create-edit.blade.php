{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Produto')

{{--@section('content_header')--}}
    {{--<h1>Categoria</h1>--}}
{{--@stop--}}

@section('content')

        @include('includes.alerts')

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Produto</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                </div>
            </div>

            <div class="box-body">

                @isset($stock)
                    {{ Form::model($stock, array('route' => array('stock.update', $stock->id),'method' => 'PUT' ,'class' => 'form'))}}
                @else
                    {{ Form::open(array('route' => 'stock.store','class' => 'form')) }}
                @endisset
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            {{Form::label('name', 'Nome',['class' => 'control-label'])}}
                            {{Form::text('product[name]',null,['class' => 'form-control', 'placeholder' => 'Nome'])}}
                        </div>
                        <div class="form-group col-lg-6">
                            {{Form::label('description', 'Descrição',['class' => 'control-label'])}}
                            {{Form::text('product[description]',null,['class' => 'form-control', 'placeholder' => 'Descrição'])}}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            {{Form::label('price', 'Valor',['class' => 'control-label'])}}
                            {{Form::text('product[price]',null,['class' => 'form-control', 'placeholder' => 'Valor'])}}
                        </div>
                        <div class="form-group col-lg-4">
                            {{Form::label('amount', 'Quantidade',['class' => 'control-label'])}}
                            {{Form::text('amount',null,['class' => 'form-control', 'placeholder' => 'Quantidade'])}}
                        </div>
                        <div class="form-group col-lg-4">
                            {{Form::label('category', 'Categoria',['class' => 'control-label'])}}
                            {{Form::select('product[category_id]',$categories,null,['id' => 'categories', 'class' => 'form-control','placeholder' => ''])}}
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

    {{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}
@stop

@section('js')
    <script src="{{asset('js/close_alerts.js')}}"></script>

@stop