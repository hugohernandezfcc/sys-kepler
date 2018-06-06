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
                                                    <tr>
                                                        <td colspan="3"><strong>No hay maestros / tutores</strong> ​dentro de Kepler. Invitar</td>
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
                                                    <tr>
                                                        <td colspan="3" class="text-center"><strong>No hay estudiantes / usuarios</strong> ​dentro de Kepler. <a href="/">Invitar</a></td>
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
                                                @foreach ($courses as $course)
                                                <tr>
                                                    <td>{{ $course->name }}</td>
                                                    <td>{{ $course->description }}</td>
                                                    <td>{{ $course->start }}</td>
                                                    <td>{{ $course->end }}</td>
                                                    <td>{{ $course->created_at->toFormattedDateString() }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    });
</script>

@elseif($typeView == 'view')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Wizard</h5>
            <div class="ibox-tools">
                <a href="/home">
                    Cancelar
                </a>
            </div>
        </div>
        <div class="ibox-content">
            @include('layouts._spinner_code')
            <form id="form" method="post" action="/wizard/store" class="wizard-big">
                {{ csrf_field() }}
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
                                <select class="form-control" name="start" id="start" required>
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

                            <div class="form-group">
                                <label>Fin *</label>
                                <select class="form-control" name="end" id="end" required>
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
            removeSubjectAreaName(cadena);
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
            $("#selectSubjectArea option[value='"+text+"']").remove();
        }
        li.appendChild(span);
    }

    function removeSubjectAreaName(areaName) {
        var subjects = $('#newSubjectsUl LI');
        var listDelete = [];
        for (var i = 0; i < subjects.length; i++) {
            var txtSubject = subjects[i].outerText;
            if (areaName === txtSubject.substr(-areaName.length)) {
                listDelete.push(i);
            }
        }
        for (var j = 0; j < listDelete.length; j++) {
            var txtSubject = subjects[listDelete[j]].outerText;
            var text = txtSubject.substring(0, txtSubject.length - 1);
            $("#selectSubjectArea option[value='"+text+"']").remove();
            subjects[listDelete[j]].remove();
        }
        if ($('#newSubjectsUl LI').length === 0) {
            $('#newSubjectsUl').addClass('hidden');
        }
    }
</script>

@endif
@include('layouts._script_spinner_code')
@endsection