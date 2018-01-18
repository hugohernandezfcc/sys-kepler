@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Ciclos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Kepler</a>
                </li>
                <li class="active">
                    <strong>Ciclos de la organización</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="/cyclescontrol/create" class="btn btn-primary btn-sm">Agregar Ciclo</a>
            </div>
        </div>
    </div>

    

    @if($typeView == 'form') 
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Registra la información <small>Ciclos escolares.</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="get" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Título</label>
                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Inicio</label>
                                <div class="col-sm-10"><input type="text" name="start" id="start" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fin</label>
                                <div class="col-sm-10"><input type="text" name="end" id="end" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-10"><textarea name="description" class="form-control"></textarea> </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @else
        sd
    @endif

@endsection