@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">Nuevo</span>
                        <h5>Áreas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">232</h1>
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        <small>Total de áreas activas</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">Nuevo</span>
                        <h5>Asignaturas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">105</h1>
                        <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                        <small>Asignaturas</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">Nuevo</span>
                        <h5>Alumnos</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">106,120</h1>
                        <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                        <small>Alumnos activos</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">Nuevo</span>
                        <h5>Bajas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">10</h1>
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                        <small>Alumnos dados de baja</small>
                    </div>
                </div>
            </div>
        </div>

        
        
    </div>
@endsection
