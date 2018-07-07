@extends('layouts.app')

@section('content')
<!--
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Cursos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Cursos de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Cursos de la organización
            </li>
            <li class="active">
                <strong>Crear curso</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/courses/create" class="btn btn-primary btn-sm">Agregar Curso</a>
        </div>

        @elseif($typeView == 'form')

        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>


        @endif
    </div>
</div>
-->


@if($typeView == 'viewCosts') 
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Wizard Costos</h5>
            <div class="ibox-tools">
                <a href="/home">
                    Cancelar
                </a>
            </div>
        </div>
        <div class="ibox-content">
            @include('layouts._spinner_code')
            <form id="form" method="post" action="#" class="wizard-big">
                {{ csrf_field() }}
                <h1>Maestros / Tutores</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nombre </th>
                                                    <th>Correo </th>
                                                    <th>Fecha de registro </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($users['master']))
                                                    @foreach ($users['master'] as $user)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td><i class="fa fa-envelope"> </i> {{ $user->email }}</td>
                                                        <td>{{ $user->created_at->toFormattedDateString() }}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    @if (isset($inscriptions['master']))
                                                        <tr>
                                                            <td colspan="3" class="text-center"><strong>No hay maestros / tutores</strong> ​dentro de Kepler. <a href="#modalMaster" id="openBtn" data-toggle="modal">Invitar</a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="3" class="text-center"><strong>No hay maestros / tutores</strong> ​dentro de Kepler. <a href="/configurations/createinscriptions/master">Invitar</a></td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h1>Estudiantes / usuarios</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nombre </th>
                                                    <th>Correo </th>
                                                    <th>Fecha de registro </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($users['student']))
                                                    @foreach ($users['student'] as $user)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td><i class="fa fa-envelope"> </i> {{ $user->email }}</td>
                                                        <td>{{ $user->created_at->toFormattedDateString() }}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    @if (isset($inscriptions['student']))
                                                        <tr>
                                                            <td colspan="3" class="text-center"><strong>No hay estudiantes / usuarios</strong> ​dentro de Kepler. <a href="#modalStudent" id="openBtn" data-toggle="modal">Invitar</a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="3" class="text-center"><strong>No hay estudiantes / usuarios</strong> ​dentro de Kepler. <a href="/configurations/createinscriptions/student">Invitar</a></td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h1>Cursos</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nombre </th>
                                                    <th>Descripción </th>
                                                    <th>Inicio </th>
                                                    <th>Fin </th>
                                                    <th>Creado </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($courses))
                                                    @foreach ($courses as $course)
                                                    <tr>
                                                        <td>{{ $course->name }}</td>
                                                        <td>{{ $course->description }}</td>
                                                        <td>{{ $course->start }}</td>
                                                        <td>{{ $course->end }}</td>
                                                        <td>{{ $course->created_at->toFormattedDateString() }}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center"><strong>No hay cursos</strong> ​dentro de Kepler. <a href="/wizard/course/costs">Invitar</a></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
            @if (!isset($users['master']) AND isset($inscriptions['master']))
            <div class="modal fade" id="modalMaster">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 class="modal-title">Seleccione un proceso de inscripción</h3>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center"></h5>
                            <table class="table table-striped table-bordered table-hover dataTables-modal" >
                                <thead>
                                    <tr>
                                        <th>Ruta</th>
                                        <th>Descripción</th>
                                        <th>Fecha de creación</th>
                                        <th>Creado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscriptions['master'] as $rec)
                                    <tr class="gradeX">
                                        <td>{{ asset('/register/'.$rec->name) }}</td>
                                        <td>{{ $rec->description }}</td>
                                        <td>{{ $rec->created_at }}</td>
                                        <td>{{ $rec->user->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Ruta</th>
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
            @endif

            @if (!isset($users['student']) AND isset($inscriptions['student']))
            <div class="modal fade" id="modalStudent">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 class="modal-title">Seleccione un proceso de inscripción</h3>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center"></h5>
                            <table class="table table-striped table-bordered table-hover dataTables-modal" >
                                <thead>
                                    <tr>
                                        <th>Ruta</th>
                                        <th>Descripción</th>
                                        <th>Fecha de creación</th>
                                        <th>Creado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscriptions['student'] as $rec)
                                    <tr class="gradeX">
                                        <td>{{ asset('/register/'.$rec->name) }}</td>
                                        <td>{{ $rec->description }}</td>
                                        <td>{{ $rec->created_at }}</td>
                                        <td>{{ $rec->user->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Ruta</th>
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
            @endif
        </div>
    </div>
</div>
<script>
    $(function () {

        $('.tab-pane').css('height', '200px');

        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            /* Labels */
            labels: {
                cancel: "Cancelar",
                current: "paso actual:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 0)
                {
                    //$(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    //$(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                prepareAreasSubjects();
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
            errorPlacement: function (error, element)
            {
                element.before(error);
            }
        });

        $('.dataTables-modal').DataTable({
            pageLength: 10,
            responsive: true,
            "scrollCollapse": true,
            "language": {
                "lengthMenu":   "Mostrar _MENU_ registros por página",
                "zeroRecords":  "No se ha encontrado",
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
        $('div.dataTables_filter input').attr("placeholder","Buscar proceso de inscripción");
    });

    
</script>

@elseif($typeView == 'view')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Wizard</h5>
            <div class="ibox-tools">
                @if ($viewReturn === null)
                <a href="/home">
                @else
                <a href="/wizard/{{ $viewReturn }}">
                @endif
                    Cancelar
                </a>
            </div>
        </div>
        <div class="ibox-content">
            @include('layouts._spinner_code')
            <form id="form" method="post" action="/wizard/store" class="wizard-big">
                {{ csrf_field() }}
                @if ($viewReturn !== null)
                <input type="hidden" name="viewReturn" value="/wizard/costs">
                @endif
                <h1>Cursos</h1>
                <fieldset>
                    <h2>Información del curso</h2>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Título *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Descripción *</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Inicio *</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" min="{{ $hoy }}" required>
                            </div>
                            <span id="dates-error" class="hidden span-error">La fecha de inicio debe ser menor a la fecha fin.</span>
                            <div class="form-group">
                                <label>Fin *</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" min="{{ $hoy }}" required>
                            </div>

                        </div>
                    </div>
                    <p>(*) Requerido</p>
                </fieldset>

                <h1>Áreas</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="areaName" placeholder="Nombre del área">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" title="Agregar una nueva área" onclick="newElementArea()" type="button"><i class="fa fa-plus"> </i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-11">
                        <span id="areaName-error" class="hidden span-error">Debe agregar al menos un área.</span>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                        </div>
                        <div class="col-lg-9">
                            <ul id="newAreasUl" class="hidden" required>
                            </ul>
                        </div>
                    </div>
                </fieldset>

                <h1>Asignaturas</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" id="subjectName" placeholder="Nombre de la asignatura">
                        </div>
                        <div class="col-lg-5">
                            <select class="form-control" id="areas_id">
                                <option value="0" selected>Seleccione un área</option>
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <button class="btn btn-default" title="Agregar una nueva asignatura" onclick="newElementSubject()" type="button"><i class="fa fa-plus"> </i></button>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>
                    <div class="col-lg-5">
                        <span id="subjectName-error" class="hidden span-error">Debe agregar al menos una asignatura.</span>
                    </div>
                    <div class="col-lg-5">
                        <span id="areas_id-error" class="hidden span-error">Debe seleccionar un área.</span>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-2">
                        </div>
                        <div class="col-lg-9">
                            <ul id="newSubjectsUl" class="hidden" required>
                            </ul>
                        </div>
                    </div>
                </fieldset>

                <h1>Participantes</h1>
                <fieldset>
                    <div class="row">
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-10">
                            <!-- Lista de grupos -->
                            <div class="input">
                                <input type="text" placeholder="Buscar grupo " title="Escriba el nombre de un grupo" id="buscar_grupo" onkeyup="buscarGrupo()" class="input form-control">
                            </div>
                            <div>
                                <span id="groups-error" class="hidden span-error">Debe agregar al menos un grupo.</span>
                            </div>
                            <div class="clients-list">
                                <ul class="nav nav-tabs">
                                    <li class="active quitarStyleLi"><a data-toggle="tab" href="#tab-1" onclick="habilitarDeshabilitarBuscador('tab-1')"><i class="fa fa-group"></i> Grupos</a></li>
                                    <li class="quitarStyleLi"><a data-toggle="tab" href="#tab-2" onclick="habilitarDeshabilitarBuscador('tab-2')"><i class="fa fa-plus"></i> Agregados</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="tabla_grupos">
                                                    <tbody>
                                                        @foreach ($groups as $group)
                                                            <tr id="{{$group->id}}" name="{{$group->id}}">
                                                                <td>{{ $group->name }}</td>
                                                                <td><a class="btn btn-primary btn-xs" onclick="moverGrupo({{$group->id}}, 1)"><i class="fa fa-plus"> </i> Agregar</a></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-2" class="tab-pane">
                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table id="tabla_agregados" class="table table-striped table-hover">
                                                    <tbody>
                                                    </tbody> 
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input name="areas" id="areas" type="hidden">
                                <input name="subjects" id="subjects" type="hidden">
                                <input name="groups" id="groups" type="hidden">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h1>Fin</h1>
                <fieldset>
                    <h2>Funcionalidades de colaboración por asignatura</h2>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-1"></div>
                            <label class="col-lg-2 control-label">Seleccione las funcionalidades que desea generar</label>
                            <div class="col-lg-2">
                                <div class="checkbox checkbox-success">
                                    <input id="muro" name="muro" type="checkbox" onchange="funcionalidades()"><label for="muro"> Muro </label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input id="foro" name="foro" type="checkbox" onchange="funcionalidades()"><label for="foro"> Foro </label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input id="articulo" name="articulo" type="checkbox" onchange="funcionalidades()"><label for="articulo"> Artículo </label>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                            <label class="col-lg-2 control-label select-function">Seleccione las asignaturas</label>
                            <div class="col-lg-4 select-function">
                                <select id="selectSubjectArea" name="selectSubjectArea[]" class="full-width" size="8" multiple>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        lista_grupos = [];

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
        });
        $('.select-function').addClass('hidden');

        $('.tab-pane').height('200px');

        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            /* Labels */
            labels: {
                cancel: "Cancelar",
                current: "paso actual:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 1 && Date.parse($('#end_date').val()) <= Date.parse($('#start_date').val()))
                {
                    $('#dates-error').removeClass('hidden');
                    return false;
                } else if (newIndex === 1 && Date.parse($('#end_date').val()) > Date.parse($('#start_date').val())) {
                    $('#dates-error').addClass('hidden');
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 2 && $("#newAreasUl LI").length === 0)
                {
                    $('#areaName-error').removeClass('hidden');
                    return false;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && $("#newSubjectsUl LI").length === 0)
                {
                    $('#subjectName-error').removeClass('hidden');
                    return false;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 4 && $('#tabla_agregados tbody tr').length === 0)
                {
                    $('#groups-error').removeClass('hidden');
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 0)
                {
                    //$(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    //$(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                prepareAreasSubjects();
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
            errorPlacement: function (error, element)
            {
                element.before(error);
            }
        });
        trUser = '';
        $('#groups').val(lista_grupos);

        document.getElementById('start_date').valueAsDate = new Date();
        document.getElementById('end_date').valueAsDate = new Date();
    });
</script>
<script type="text/javascript">
    function funcionalidades() {
        if ($('#muro').prop('checked') || $('#foro').prop('checked') || $('#articulo').prop('checked')) {
            $('.select-function').removeClass('hidden');
            $('#selectSubjectArea').attr('required', true);
        } else {
            $('#selectSubjectArea').attr('required', false);
            $('.select-function').addClass('hidden');
        }
    }

    function moverGrupo(idGrupo, accion) {
        trUser = $("#" + idGrupo)[0];
        if (accion === 1) {
            if (!$('#groups-error').hasClass('hidden')) {
                $('#groups-error').addClass('hidden');
            }
            lista_grupos.push(idGrupo);
            $("#"+idGrupo+" td:eq(1)").html('<a class="btn btn-default btn-xs" onclick="moverGrupo(' + idGrupo + ', 2)"><i class="fa fa-minus"> </i> Remover</a>');
            $("#tabla_grupos tr#" + idGrupo).remove();
            $("#tabla_agregados").append(trUser);
        } else {
            $("#"+idGrupo+" td:eq(1)").html('<a class="btn btn-primary btn-xs" onclick="moverGrupo(' + idGrupo + ', 1)"><i class="fa fa-plus"> </i> Agregar</a>');
            $("#tabla_agregados tr#" + idGrupo).remove();
            $("#tabla_grupos").append(trUser);
            lista_grupos = $.grep(lista_grupos, function(value) {
                return value != idGrupo;
            });
        }
        $('#groups').val(lista_grupos);
        if ($("#buscar_grupo").val() !== '') {
            $("#buscar_grupo").val('');
            buscarGrupo();
        }
    }
    
    function habilitarDeshabilitarBuscador(tab) {
        if (tab === 'tab-1') {
            $("#buscar_grupo").prop('disabled', false);
        } else {
            $("#buscar_grupo").val('');
            buscarGrupo();
            $("#buscar_grupo").prop('disabled', true);
        }
    }
    
    function buscarGrupo() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("buscar_grupo");
        filter = input.value.toUpperCase();
        table = document.getElementById("tabla_grupos");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > - 1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function prepareAreasSubjects() {
        var areas = $('#newAreasUl LI');
        var listAreas = [];
        var subjects = $('#newSubjectsUl LI');
        var listSubjects = [];
        for (var i = 0; i < areas.length; i++) {
            var txtArea = areas[i].outerText;
            var txt = txtArea.substring(0, txtArea.length - 1);
            listAreas.push(txt);
        }
        $('#areas').val(listAreas);
        for (var i = 0; i < subjects.length; i++) {
            var txtSubject = subjects[i].outerText;
            var txt = txtSubject.substring(0, txtSubject.length - 1);
            listSubjects.push(txt);
        }
        $('#subjects').val(listSubjects);
    }

    // Create a new list item Area when clicking on the "Add" button
    function newElementArea() {
        var li = document.createElement("li");
        var inputValue = document.getElementById("areaName").value;
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        if (inputValue === '') {
            return false;
        } else {
            $('#areaName-error').addClass('hidden');
            $('#newAreasUl').removeClass('hidden');
            document.getElementById("newAreasUl").appendChild(li);
            var selectArea = document.getElementById("areas_id");
            var option = document.createElement("option");
            option.text = inputValue;
            option.value = inputValue;
            selectArea.add(option);
        }
        document.getElementById("areaName").value = "";

        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.appendChild(txt);
        span.className = "closeElement";
        span.title = "Eliminar área";
        span.onclick = function() {
            var element = $(this).parent();
            var cadena = element.text();
            var text = cadena.substring(0, cadena.length - 1);
            var ul = element.parent().attr('id');
            element.remove();
            if ($('#'+ul+' LI').length === 0) {
                $('#'+ul).addClass('hidden');
            }
            $("#areas_id option[value='"+text+"']").remove();
        }
        li.appendChild(span);
    }

    // Create a new list item Subject when clicking on the "Add" button
    function newElementSubject() {
        var li = document.createElement("li");
        var inputValue = $("#subjectName").val();
        var selectName = $('#areas_id').val();
        var t = document.createTextNode(inputValue + ' / ' + selectName);
        li.appendChild(t);
        if (inputValue === '') {
            return false;
        } else if ($('#areas_id').val() === '0') {
            $('#areas_id-error').removeClass('hidden');
            return false;
        } else {
            $('#newSubjectsUl').removeClass('hidden');
            $('#subjectName-error').addClass('hidden');
            $('#areas_id-error').addClass('hidden');
            document.getElementById("newSubjectsUl").appendChild(li);
            var selectSubjectArea = document.getElementById("selectSubjectArea");
            var option = document.createElement("option");
            option.text = inputValue + ' / ' + selectName;
            option.value = inputValue + ' / ' + selectName;
            selectSubjectArea.add(option);
            noDeleteArea(selectName);
        }
        $("#subjectName").val('');
        $('#areas_id').val('0');

        var span = document.createElement("SPAN");
        var txt = document.createTextNode("\u00D7");
        span.appendChild(txt);
        span.className = "closeElement";
        span.title = "Eliminar asignatura";
        span.onclick = function() {
            var element = $(this).parent();
            var cadena = element.text();
            var text = cadena.substring(0, cadena.length - 1);
            var ul = element.parent().attr('id');
            element.remove();
            if ($('#'+ul+' LI').length === 0) {
                $('#'+ul).addClass('hidden');
            }
            addDeleteArea(text);
        }
        li.appendChild(span);
    }

    function noDeleteArea(areaName) {
        var areas = $('#newAreasUl LI');
        for (var i = 0; i < areas.length; i++) {
            var txt = (areas[i].outerText).substring(0, (areas[i].outerText).length - 1);
            if (areaName === txt) {
                areas[i].lastElementChild.className = "hidden";
                areas[i].title = "No se puede eliminar esta área";
                break;
            }
        }
    }

    function addDeleteArea(subjectName) {
        var cant = 0;
        var subjects = $('#newSubjectsUl LI');
        for (var i = 0; i < subjects.length; i++) {
            if (cant > 0) {
                break;
            } else {
                var texto = subjects[i].outerText.split('/')[1];
                var txt = texto.substring(1, texto.length - 1);
                if (areaName == txt) {
                    ++cant;
                }
            }
        }
        if (cant === 0) {
            var areas = $('#newAreasUl LI');
            for (var i = 0; i < areas.length; i++) {
                var txt = (areas[i].outerText).substring(0, (areas[i].outerText).length - 1);
                areaName = (subjectName.split('/')[1]).substring(1, subjectName.length);
                if (areaName === txt) {
                    areas[i].lastElementChild.className = "closeElement";
                    areas[i].title = "";
                }
            }
        }
    }
</script>

@endif
@include('layouts._script_spinner_code')
@endsection