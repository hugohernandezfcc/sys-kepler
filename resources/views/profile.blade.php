@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Perfil</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Perfil</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Perfil
            </li>
            <li class="active">
                <strong>Editar perfil</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            @if (Auth::user()->type == "admin")
                <a href="/configurations/create" class="btn btn-primary btn-sm">Agregar columna tabla Users</a>
            @endif
            <a href="/profile/edit" class="btn btn-primary btn-sm">Editar perfil</a>
        </div>

        @elseif($typeView == 'form')

        <div class="title-action">
            <a onclick="document.getElementById('form-update').submit();" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </a>
        </div>


        @endif
    </div>
</div>



@if($typeView == 'form')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edita tu información</h5>
                <div class="ibox-tools">
                    <a href="/profile">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form enctype="multipart/form-data" method="post" action="/profile/update" id="form-update" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre</label>

                        <div class="col-sm-10"><input type="text" name="name" value="{{ $record->name }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Correo</label>

                        <div class="col-sm-10"><input type="text" name="email" value="{{ $record->email }}" disabled="true" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Imagen de perfil</label>
                        <div class="col-sm-10">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Seleccionar imagen</span>
                                    <span class="fileinput-exists">Cambiar</span>
                                    <input type="file" name="avatar" />
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    @foreach ($camposUsers as $campo)
                        @php($valorCampo = $campo['valor'])
                        <div class="form-group"><label class="col-sm-2 control-label">{{ucwords($valorCampo)}}</label>
                            @if($campo['tipo'] == 'string')
                                <div class="col-sm-10"><input type="text" name="{{$valorCampo}}" value="{{$record->$valorCampo}}" class="form-control"></div>
                            @elseif($campo['tipo'] == 'integer')
                                <div class="col-sm-10"><input type="number" name="{{$valorCampo}}" value="{{$record->$valorCampo}}" class="form-control"></div>
                            @else
                                <div class="col-sm-10"><input type="date" name="{{$valorCampo}}" value="{{date('Y-m-d', strtotime($record->$valorCampo))}}" class="form-control"></div>
                            @endif
                        </div>
                        <div class="hr-line-dashed"></div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>
</div>
@elseif($typeView == 'list')
<div class="wrapper wrapper-content animated fadeInRight">
</div>

@elseif($typeView == 'view')
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <img src="{{ asset('uploads/avatars/'. $record->avatar) }}" alt="image" class="img-circle" width="10%">
                                <h2>Nombre y apellido: {{$record->name}}</h2>
                                @foreach ($camposUsers as $campo)
                                    @php($valorCampo = $campo['valor'])
                                    @if($campo['tipo'] == 'string' OR $campo['tipo'] == 'integer')
                                        {{ucwords($valorCampo)}}: {{$record->$valorCampo}} <br>
                                    @else
                                        @if($record->$valorCampo !== null)
                                            {{ucwords($valorCampo)}}: {{date('d-m-Y', strtotime($record->$valorCampo))}} <br>
                                        @else
                                            {{ucwords($valorCampo)}}: <br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection