@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Ciclos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Kepler</a>
                </li>
                @if($typeView != 'form')
                    <li class="active">
                        <strong>Ciclos de la organización</strong>
                    </li>
                @elseif($typeView == 'form')
                    <li>
                        Ciclos de la organización
                    </li>
                    <li class="active">
                        <strong>Crear ciclo</strong>
                    </li>
                @endif

            </ol>
        </div>
        <div class="col-sm-8">
            @if($typeView != 'form')
                <div class="title-action">
                    <a href="/cyclescontrol/create" class="btn btn-primary btn-sm">Agregar Ciclo</a>
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
                        <h5>Registra la información <small>Ciclos escolares.</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="/cyclescontrol">
                                Cancelar
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="/cyclescontrol/store" id="form-create" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Título</label>
                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Inicio</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="start" id="start">
                                        <option value="">Seleccionar mes</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fin</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="end" id="end">
                                        <option value="">Seleccionar mes</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Noviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
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
      
    @elseif($typeView == 'list')
        <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Basic Data Tables example with responsive plugin</h5>
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
                                <th> - </th>
                                <th>Nombre</th>
                                <th>Inicia en</th>
                                <th>Finaliza en</th>
                                <th>Fecha de creación</th>
                                <th>Creado por</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach ($records as $rec)
                            
                             <tr class="gradeX">
                                <td> 
                                    <a href="/cyclescontrol/show/{{ $rec->id }}" class="btn btn-primary dim">
                                        <i class="fa fa-eye"></i>
                                    </a> 
                                </td>
                                <td>{{ $rec->name }}</td>
                                <td>{{ $rec->start }}</td>
                                <td>{{ $rec->end }}</td>
                                <td>{{ $rec->created_at }}</td>
                                <td>{{ $rec->created_by }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> - </th>
                                <th>Nombre</th>
                                <th>Inicia en</th>
                                <th>Finaliza en</th>
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

    @elseif($typeView == 'view')
        detalle
    @endif

@endsection