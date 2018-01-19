@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Asignaturas</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Kepler</a>
                </li>
                @if($typeView != 'form')
                    <li class="active">
                        <strong>Asignaturas de la organización</strong>
                    </li>
                @elseif($typeView == 'form')
                    <li>
                        Asignaturas de la organización
                    </li>
                    <li class="active">
                        <strong>Crear asignatura</strong>
                    </li>
                @endif

            </ol>
        </div>
        <div class="col-sm-6">
            @if($typeView != 'form')
                <div class="title-action">
                    <a href="/subjects/create" class="btn btn-primary btn-sm">Agregar asignatura</a>
                </div>

            @elseif($typeView == 'form')

                <div class="title-action">
                    <a onclick="document.getElementById('form-create').submit(); " class="btn btn-primary btn-sm">
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
                        <h5>Registra la información <small>Asignatura.</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="/subjects/store" id="form-create" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group"><label class="col-sm-2 control-label">Nombre de la asignatura</label>

                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Área</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="area_id" id="area_id">
                                        
                                        @foreach ($to_related as $to)
                                            <option value="{{$to->id}}">{{$to->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
    
        <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Lista de asignaturas</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                            </div>
                        </div>
                        <div class="ibox-content">

                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                        <tr>
                            <th>Nombre de asignatura</th>
                            <th>Fecha de creación</th>
                            <th>Creado por</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @foreach ($records as $rec)
                            
                             <tr class="gradeX">
                                <td>{{ $rec->name }}</td>
                                <td>{{ $rec->created_at }}</td>
                                <td>Admin</td>
                            </tr>

                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>Nombre de asignatura</th>
                            <th>Fecha de creación</th>
                            <th>Creado por</th>
                        </tr>
                        </tfoot>
                        </table>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
        </div>
    @endif
@endsection