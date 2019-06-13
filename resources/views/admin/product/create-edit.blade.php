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
            {{--<strong>Sucesso!</strong> A produto {{session('data')->nome}} foi adicionado com sucesso!--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">--}}
                {{--<span aria-hidden="true">&times;</span>--}}
            {{--</button>--}}
        {{--</div>--}}
    {{--@endif--}}
    {{--@if(count($errors) > 0)--}}
        {{--<div class="alert alert-danger" id="alert">--}}
            {{--<ul>--}}
                {{--@foreach($errors->all() as $error)--}}
                    {{--<li>{{ $error }}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--@endif--}}

        @include('includes.alerts')

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Produto</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
                </div>
            </div>

            <div class="box-body">

                @isset($data)
                    {{ Form::model($data, array('route' => array('product.update', $data->id),'method' => 'PUT' ,'class' => 'form-horizontal'))}}
                @else
                    {{ Form::open(array('route' => 'product.store','class' => 'form-horizontal')) }}
                @endisset


                <div class="form-group col-lg-12">
                    {{Form::label('name', 'Nome',['class' => 'control-label'])}}
                    {{Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Nome'])}}
                </div>
                <div class="form-group col-lg-12">
                    {{Form::label('description', 'Descrição',['class' => 'control-label'])}}
                    {{Form::text('description',null,['class' => 'form-control', 'placeholder' => 'Descrição'])}}
                </div>
                    <div class="form-group col-lg-12">
                        {{Form::label('price', 'Valor',['class' => 'control-label'])}}
                        {{Form::text('price',null,['class' => 'form-control', 'placeholder' => 'Valor'])}}
                    </div>
                    <div class="form-group col-lg-12">
                        {{Form::label('amount', 'Quantidade',['class' => 'control-label'])}}
                        {{Form::text('amount',null,['class' => 'form-control', 'placeholder' => 'Quantidade'])}}
                    </div>
                    <div class="form-group col-lg-12">
                        {{Form::label('category', 'Categoria',['class' => 'control-label'])}}
                        {{Form::select('category_id',$category,null,['id' => 'categories', 'class' => 'form-control','placeholder' => ''])}}
                    </div>
                <div class="form-group col-lg-12">
                    <div class="col-lg-offset-2">
                        {{Form::submit('Salvar',['class' => 'btn btn-lg btn-info pull-right'])}}
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

    {{--<script>--}}
        {{--$(document).ready(function () {--}}

            {{--setTimeout(function() {--}}
                {{--$('#alertMsg1').hide("slow","linear","blind");--}}
            {{--}, 5000);--}}

        {{--});--}}
    {{--</script>--}}
@stop