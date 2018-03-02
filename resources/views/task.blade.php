@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <input type="hidden" id="typeView" value="{{ $typeView }}">
    <div class="col-sm-6">
        <h2>Tareas</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Tareas de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Tareas de la organización
            </li>
            <li class="active">
                <strong>Crear tarea</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView == 'list')
        <div class="title-action">
            <a href="/task/create" class="btn btn-primary btn-sm">Agregar tarea</a>
        </div>

        @elseif($typeView == 'form')

        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>

        @elseif($typeView == 'view')
        <div class="title-action">
            <a href="/results/task-{{ $record->id }}" class="btn btn-primary">Respuestas tarea</a>
            <a href="#modalGroups" id="openBtn" data-toggle="modal" data-exam="{{ $record->id }}" class="btn btn-primary">Aplicar tarea</a>
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
                <h5>Registra la información <small>Tarea.</small></h5>
            </div>
            <div class="ibox-content">
                <form method="post" role='form' action="/task/store" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="totalQuestion" id="totalQuestion" value="1" type="hidden">
                    <div class="form-group"><label class="col-sm-2 control-label">Titulo tarea</label>

                        <div class="col-sm-10"><input type="text" name="name" class="form-control" required="true"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Descripción de actividad</label>
                        <div class="col-sm-10"><textarea name="description" class="form-control"></textarea> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Asignatura</label>
                        <div class="col-sm-10">
                            <select class="form-control select-subject" name="subject_id" id="subject_id" required="true">
                                <option></option>
                                @foreach ($to_related as $to_subject)
                                <option disabled="" class="font-bold">Área {{$to_subject[0]->area->name}}</option>
                                    @foreach ($to_subject as $to)
                                    <option value="{{$to->id}}">{{$to->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                    <h5>Lista de tareas</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Título tarea</th>
                                    <th>Área</th>
                                    <th>Asignatura</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/task/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ $rec->name }}</td>
                                    <td>{{ $rec->area->name }}</td>
                                    <td>{{ $rec->subject->name }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Título tarea</th>
                                    <th>Área</th>
                                    <th>Asignatura</th>
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
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <a href="/task" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        <h2>Tarea: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                    <h4>Descripción de actividad:</h4>
                    <p>
                        {{ $record->description }}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Área:</dt> <dd>{{ $record->area->name }}</dd>
                        <dt>Asignatura:</dt> <dd>{{ $record->subject->name }}</dd>
                    </dl>
                </div>
                <div class="col-lg-6" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Participante:</dt> <dd>{{ Auth::user()->name }}</dd>
                        <dt>Grupo:</dt> <dd></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalGroups">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="modal-title">Seleccione el grupo al que desee aplicar la tarea</h3>
                </div>
                <div class="modal-body">
                    <h5 class="text-center"></h5>
                    <table class="table table-striped table-bordered table-hover dataTables-modal" >
                        <thead>
                            <tr>
                                <th>Aplicar</th>
                                <th>Nombre del grupo</th>
                                <th>Descripción</th>
                                <th>Fecha de creación</th>
                                <th>Creado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($to_related as $group)
                            <tr class="gradeX">
                                @if (count($group->tasks()->where('task_id', '=', $record->id)->get()) === 0)
                                <td class="text-center">
                                    <button type="button" onclick="applyTask(this, {{ $group->id }})" class="btn btn-primary btn-xs">
                                        Aplicar
                                    </button> 
                                </td>
                                @else
                                <td class="text-center">
                                    <button type="button" class="btn btn-default btn-xs" disabled>
                                        Aplicado
                                    </button> 
                                </td>
                                @endif
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->description }}</td>
                                <td>{{ $group->created_at }}</td>
                                <td>{{ $group->user->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Aplicar</th>
                                <th>Nombre del grupo</th>
                                <th>Descripción</th>
                                <th>Fecha de creación</th>
                                <th>Creado por</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endif

<script>
    $(function() {
        $('.select-subject').select2({
            placeholder: 'Seleccione una asignatura',
            allowClear: true
        });
        if ($('#typeView').val() === 'form') {
            tipoRespuesta(document.getElementById("subtype1"));
            $('#botonEliminar').addClass('hidden');
        } else if($('#typeView').val() === 'view') {
            $('.dataTables-modal').DataTable({
                pageLength: 10,
                responsive: true,
                "scrollCollapse": true,
                "language": {
                    "lengthMenu":   "Mostrar _MENU_ registros por página",
                    "zeroRecords":  "No se ha encontrado - sorry",
                    "info":         "Página _PAGE_ de _PAGES_",
                    "infoEmpty":    "Registros no disponibles",
                    "search":       "",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       " Siguiente ",
                        "previous":   " Anterior "
                    },
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            });
            $('div.dataTables_filter input').addClass('slds-input');
            $('div.dataTables_filter input').attr("placeholder","Buscar grupo");
        }
    });
    
    function applyTask(e, groupId) {
        $(e).prop('disabled',true);
        $(e).before('<button class="buttonload btn btn-primary btn-xs" disabled><i class="fa fa-spinner fa-spin"></i> </button>');
        $(e).addClass("hidden");
        var taskId = $('#idRecord').val();
        $.ajax({
            url: "/applytasks/store",
            data: { 
                "taskId":taskId,
                "groupId":groupId,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                $(e).removeClass('btn-primary');
                $(e).addClass('btn-default');
                $(e).html('Aplicado');
                $(e).removeClass("hidden");
                $('.buttonload').remove();
                console.log('applytasks/taketask/'+result.codeTask);
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
</script>
@endsection