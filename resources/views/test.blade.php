@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Exámenes</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Exámenes de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Exámenes de la organización
            </li>
            <li class="active">
                <strong>Crear examen</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/test/create" class="btn btn-primary btn-sm">Agregar examen</a>
        </div>

        @elseif($typeView == 'form')

        <div class="title-action">
            <a onclick="document.getElementById('form-create').submit();" class="btn btn-primary btn-sm">
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
                <h5>Registra la información <small>Examen.</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a href="/test">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="post" action="/test/store" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="totalQuestion" id="totalQuestion" value="1" type="hidden">
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre del examen</label>

                        <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-10"><textarea name="description" class="form-control"></textarea> </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Asignatura</label>
                        <div class="col-sm-10">
                            <select class="form-control select-subject" name="subject_id" id="subject_id">
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
                    <div class="hr-line-dashed"></div>
                    <div id="questionTest1" class="questionTest">
                        <div class="form-group"><label class="col-sm-2 control-label">Pregunta</label>

                            <div class="col-sm-10"><input type="text" name="question1" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tipo de pregunta</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="question1-subtype1" id="subtype1" onchange="tipoRespuesta(this)">
                                    <option value="Question">Respuesta corta</option>
                                    <option value="Single-option">Selección simple</option>
                                    <option value="Multiple-option">Selección múltiple</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="typeQuestion1"><label class="col-sm-2 control-label">Espacio para respuesta</label>
                            <div class="col-sm-10"><textarea id="answer1" class="form-control" disabled="true"></textarea> </div>
                        </div>
                        <div class="form-group hidden" id="typeSingleOption1"><label class="col-sm-2 control-label">Seleccione una opción</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <input type="radio" radio="radio1" id="radio1" value="option1" checked="">
                                    <input type="text" name="question1-option1" class="form-control" value="Opción 1">
                                </div>
                                <div class="radio">
                                    <input type="radio" radio="radio1" id="radio2" value="option2">
                                    <input type="text" name="question1-option2" class="form-control" value="Opción 2">
                                    <a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <br>
                                    <a class="btn btn-primary" onclick="addOption(this, 'radio')">Agregar opción</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden" id="typeMultipleOption1"><label class="col-sm-2 control-label">Seleccione una o varias opciones</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox">
                                    <input type="text" name="question1-option1" class="form-control" value="Opción 1">
                                </div>
                                <div class="checkbox">
                                    <input id="checkbox2" type="checkbox">
                                    <input type="text" name="question1-option2" class="form-control" value="Opción 2">
                                    <a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <br>
                                    <a class="btn btn-primary" onclick="addOption(this, 'checkbox')">Agregar opción</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="linea-final" class="hr-line-dashed"></div>
                    <div class="btn-group">
                        <a class="btn btn-primary" onclick="addQuestion()">Agregar pregunta</a>
                        <a class="btn btn-default hidden" id='botonEliminar' onclick="removeQuestion()">Eliminar pregunta</a>
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
                    <h5>Lista de exámenes</h5>
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
                                    <th>Nombre del examen</th>
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
                                        <a href="/test/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
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
                                    <th>Nombre del examen</th>
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
                        <a href="/test" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
                        <h2>Examen: {{$record->name}}</h2>
                    </div>
                    @if($record->created_at->diffInMinutes() < 2)
                    <dl class="dl-horizontal">
                        <span class="label label-primary pull-right">Nuevo</span>
                    </dl>
                    @endif
                    <h4>Descripción del examen:</h4>
                    <p>
                        {{ $record->description }}
                    </p>
                    <h4>Área:</h4>
                    <p>
                        {{ $record->area->name }}
                    </p>
                    <h4>Asignatura:</h4>
                    <p>
                        {{ $record->subject->name }}
                    </p>

                    @foreach ($items_exam as $item_exam)
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3> {{ $item_exam->name }} </h3>
                        </div>
                        <div class="">
                        @foreach ($item_exam->children()->get() as $key => $answer)
                        
                            @if ($answer->subtype === 'Open')
                                <label class="col-sm-2 control-label">Responda brevemente</label>
                                    <div class="col-sm-10"><textarea id="answer1" class="form-control"></textarea> </div>
                                
                            @elseif ($answer->subtype === 'Single option')
                                @if ($key === 0)
                                    <label class="col-sm-2 control-label">Seleccione una opción</label>
                                @else ($key > 1)
                                    <label class="col-sm-2 control-label"></label>
                                @endif
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <input type="radio" name="radio" id="radio{{$key}}" value="{{ $answer->id }}">
                                        <label for="radio{{$key}}">
                                            {{ $answer->name }}
                                        </label>
                                    </div>
                                </div>
                            @else
                                @if ($key === 0)
                                    <label class="col-sm-2 control-label">Seleccione una o varias opciones</label>
                                @else ($key > 1)
                                    <label class="col-sm-2 control-label"></label>
                                @endif
                                <div class="col-sm-10">
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox{{$key}}" type="checkbox">
                                        <label for="checkbox{{$key}}">
                                            {{ $answer->name }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    $(function() {
        $('.select-subject').select2({
            placeholder: 'Seleccione una asignatura',
            allowClear: true
        });
        tipoRespuesta(document.getElementById("subtype1"));
        $('#botonEliminar').addClass('hidden');
    });
    
    function addQuestion() {
        var totalQuestion = $('.questionTest').length + 1;
        $('#totalQuestion').val(totalQuestion);
        var btnRadio = "\'radio\'";
        var btnCheckbox = "\'checkbox\'";
        var newQuestion = '<div id="questionTest'+totalQuestion+'" class="questionTest"><div class="hr-line-dashed"></div><div class="form-group"><label class="col-sm-2 control-label">Pregunta</label><div class="col-sm-10"><input type="text" name="question'+totalQuestion+'" class="form-control"></div></div><div class="form-group">\n\
            <label class="col-sm-2 control-label">Tipo de pregunta</label><div class="col-sm-10"><select class="form-control" name="question'+totalQuestion+'-subtype'+totalQuestion+'" id="subtype'+totalQuestion+'" onchange="tipoRespuesta(this)"><option value="Question">Respuesta corta</option>\n\
            <option value="Single-option">Selección simple</option><option value="Multiple-option">Selección múltiple</option></select></div></div><div class="form-group" id="typeQuestion'+totalQuestion+'"><label class="col-sm-2 control-label">Espacio para respuesta</label><div class="col-sm-10">\n\
            <textarea id="answer'+totalQuestion+'" class="form-control" disabled="true"></textarea> </div></div><div class="form-group hidden" id="typeSingleOption'+totalQuestion+'"><label class="col-sm-2 control-label">Seleccione una opción</label><div class="col-sm-10"><div class="radio">\n\
            <input type="radio" radio="radio1" id="radio1" value="option1" checked=""><input type="text" name="question'+totalQuestion+'-option1" class="form-control" value="Opción 1"></div><div class="radio"><input type="radio" radio="radio1" id="radio2" value="option2">\n\
            <input type="text" name="question'+totalQuestion+'-option2" class="form-control" value="Opción 2"><a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close"><span aria-hidden="true">&times;</span></a></div><div class="btn-group"><br>\n\
            <a class="btn btn-primary" onclick="addOption(this, '+btnRadio+')">Agregar opción</a></div></div></div><div class="form-group hidden" id="typeMultipleOption'+totalQuestion+'"><label class="col-sm-2 control-label">Seleccione una o varias opciones</label><div class="col-sm-10"><div class="checkbox">\n\
            <input id="checkbox1" type="checkbox"><input type="text" name="question'+totalQuestion+'-option1" class="form-control" value="Opción 1"></div><div class="checkbox"><input id="checkbox2" type="checkbox"><input type="text" name="question'+totalQuestion+'-option2" class="form-control" value="Opción 2">\n\
            <a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close"><span aria-hidden="true">&times;</span></a></div><div class="btn-group"><br><a class="btn btn-primary" onclick="addOption(this, '+btnCheckbox+')">Agregar opción</a></div></div></div></div>';
        $('#linea-final').before(newQuestion);
        if (totalQuestion === 2) {
            $('#botonEliminar').removeClass('hidden');
        }
        tipoRespuesta(document.getElementById('subtype'+totalQuestion));
    }
    
    function removeQuestion() {
        var idQuestionRemove = $('.questionTest').length;
        $('#questionTest'+idQuestionRemove).remove();
        $('#totalQuestion').val($('.questionTest').length);
        if (idQuestionRemove === 2) {
            $('#botonEliminar').addClass('hidden');
        }
    }
    
    function addOption(e, tipoInput) {
        var idQuestionTest = $(e).parents('div')[3].id;
        var nroQuestion = idQuestionTest.charAt(idQuestionTest.length-1);
        var cantOption = $(e).parent().parent().children('div').length;
        if (tipoInput === 'radio') {
            var option = '<div class="radio"> <input type="radio" radio="radio1" id="radio2" value="option2"><input type="text" name="question'+nroQuestion+'-option'+cantOption+'" class="form-control" value="Opción '+cantOption+'">\n\
                <a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close"><span aria-hidden="true">&times;</span></a></div>';
        } else {
            var option = '<div class="checkbox"><input id="checkbox2" type="checkbox"><input type="text" name="question'+nroQuestion+'-option'+cantOption+'" class="form-control" value="Opción '+cantOption+'">\n\
                <a title="Eliminar opción" class="close block" onclick="removeOption(this)" aria-label="Close"><span aria-hidden="true">&times;</span></a></div>';
        }
        $(e).parent().before(option);
    }
    
    function removeOption(e) {
        $(e).parent().remove();
    }
    
    function tipoRespuesta(selectSubtype) {
        var cadena = selectSubtype.name;
        var idSubtype = cadena.charAt(cadena.length-1);
        if (selectSubtype.value === 'Question') {
            agregarQuitarHidden('#typeQuestion'+idSubtype, '#typeSingleOption'+idSubtype, '#typeMultipleOption'+idSubtype);
            $('#typeSingleOption'+idSubtype+' :text').prop('disabled', true);
            $('#typeMultipleOption'+idSubtype+' :text').prop('disabled', true);
        } else if (selectSubtype.value === 'Single-option') {
            agregarQuitarHidden('#typeSingleOption'+idSubtype, '#typeQuestion'+idSubtype, '#typeMultipleOption'+idSubtype);
            $('#typeSingleOption'+idSubtype+' :text').prop('disabled', false);
            $('#typeMultipleOption'+idSubtype+' :text').prop('disabled', true);
        } else {
            agregarQuitarHidden('#typeMultipleOption'+idSubtype, '#typeQuestion'+idSubtype, '#typeSingleOption'+idSubtype);
            $('#typeSingleOption'+idSubtype+' :text').prop('disabled', true);
            $('#typeMultipleOption'+idSubtype+' :text').prop('disabled', false);
        }
    }
    
    function agregarQuitarHidden(atributoRemover, atributoAdd1, atributoAdd2) {
        $(atributoRemover).removeClass("hidden");
        $(atributoAdd1).addClass("hidden");
        $(atributoAdd2).addClass("hidden");
    }
    
    
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('exams', comentario, tipoComentario, idParent);
            }
        }
    }
    
    function agregarComentario(tabla, comentario, tipoComentario, idParent) {
        idRecord = $('#idRecord').val();
        var imagenUsuario = '';
        imagenUsuario = '{{ asset("uploads/avatars/". Auth::user()->avatar) }}';
        $.ajax({
            url: "/conversations/store",
            data: { 
                "table":tabla,
                "id_record":idRecord,
                "comentario":comentario,
                "type":tipoComentario,
                "parent":idParent,
                "_token": "{{ csrf_token() }}"
                },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                if (result.type === 'Question') {
                    var answer = "\'Answer\'";
                    var html = '<div class="social-avatar"><a href=""><img alt="image" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box"><div class="social-avatar"><a href="#">'+result.user_name+'</a><small class="text-muted"> - '+result.tiempo+'</small></div>\n\
                    <div class="social-body"><p>'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" src="inspinia/img/a3.jpg"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">'+result.tiempo+'</small></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" src="inspinia/img/a8.jpg"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><small class="text-muted">'+result.tiempo+'</small></div></div>';
                    $('#comentario'+result.parent).before(html);
                }
            },
            error: function () {
               //alert("fallo");
            }
            
        });
    }
    
    function habilitarComentario(idCampo) {
        if ($('#comentario'+idCampo).hasClass("hidden")) {
            $('#comentario'+idCampo).removeClass("hidden");
        }
        $('#comentario'+idCampo+' textarea').focus();    
    }
</script>
@endsection