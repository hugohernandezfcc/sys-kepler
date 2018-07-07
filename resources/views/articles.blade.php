@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Artículos</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView != 'form')
            <li class="active">
                <strong>Artículos de la organización</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Artículos de la organización
            </li>
                <li class="active">
                @if($record->exists)
                    <strong>Editar artículo</strong>
                @else
                    <strong>Crear artículo</strong>
                @endif
                </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView != 'form')
        <div class="title-action">
            <a href="/articles/create" class="btn btn-primary btn-sm">Agregar Artículo</a>
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

@if($typeView == 'form') 
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Registra la información <small>Artículo.</small></h5>
                <div class="ibox-tools">
                    <a href="/articles">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                @if($record->exists)
                <form method="post" action="/articles/update" id="form-create" class="form-horizontal">
                    {{ method_field('PUT') }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                @else
                <form method="post" action="/articles/store" id="form-create" class="form-horizontal">
                @endif
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nombre del artículo</label>
                        <div class="col-sm-10"><input type="text" name="name" class="form-control" value="{{ $record->name or old('name') }}" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Modulo</label>
                        <div class="col-sm-10">
                            @if($module->exists)
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                <select class="form-control" id="module_id" disabled>
                                    @foreach ($to_related as $to)
                                        @if($module->id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" name="module_id" id="module_id">
                                    @foreach ($to_related as $to)
                                        @if($record->module_id == $to->id)
                                            <option value="{{$to->id}}" selected>{{$to->name}}</option>
                                        @else
                                            <option value="{{$to->id}}">{{$to->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <input type="hidden" id="contenido" name="contenido">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Contenido</label>
                        <div class="col-sm-10"><textarea id="editor" class="form-control" required>{!! $record->contenido or old('contenido') !!}</textarea> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor');
        CKEDITOR.instances.editor.on("change", function() {
            $('#contenido').val(CKEDITOR.instances.editor.getData());
        });
    });
    
</script>
@elseif($typeView == 'list')

<div class="wrapper wrapper-content animated fadeInRight">
    @if (count($records) !== 0)
        <div class="grid">
            @foreach ($records as $rec)
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-title">
                        @if($rec->created_at->diffInMinutes() < 2)
                            <span class="label label-primary pull-right">Nuevo</span>
                        @endif
                        <h5 class="cortar"><a href="/articles/show/{{ $rec->id }}" > {{ $rec->name }} </a></h5>
                    </div>
                    <div class="ibox-content">
                        @include('layouts._spinner_code')
                        <div class="row  m-t-sm">
                            <div class="col-sm-6">
                                <div class="font-bold">Creado por:</div>{{ $rec->user->name }}
                            </div>
                            <div class="col-sm-6">
                                <div class="font-bold">Modulo:</div>{{ $rec->module->name }}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h4>Contenido:</h4>
                        <div class="cortar_largo">
                            <p>
                            {!! $rec->contenido !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de artículos</h5>
                    </div>
                    <div class="ibox-content">
                        @include('layouts._spinner_code')

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Nombre del artículo</th>
                                        <th>Fecha de creación</th>
                                        <th>Creado por</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($records as $rec)

                                    <tr class="gradeX">
                                        <td>{{ $rec->name }}</td>
                                        <td>{{ $rec->created_at }}</td>
                                        <td>{{ $rec->user->name }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Nombre del artículo</th>
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
    @endif
</div>

@elseif($typeView == 'view')
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<div class="wrapper wrapper-content  animated fadeInRight article">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">
                    @include('layouts._spinner_code')
                    <div class="pull-right">
                        <a href="/articles/edit/{{ $record->id }}" class="btn btn-white btn-xs"> <i class="fa fa-pencil"></i> Editar</a>
                        <a href="/articles" class="btn btn-white btn-xs"> <i class="fa fa-chevron-left"></i> Regresar</a>
                    </div>
                    <div class="text-center article-title">
                        <span class="text-muted"><i class="fa fa-clock-o"></i> {{ $record->created_at->diffForHumans() }}</span>
                        <h1>{{$record->name}}</h1>
                    </div>
                    {!! $record->contenido !!}
                    <br>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Comentarios:</h3>
                            @include('layouts._conversations')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    $(function () {
        $('#side-menu li.active').removeClass('active');
        var url = jQuery(location).attr('href').split('/')[3];
        $("#side-menu [href='/" + url +"']").parent().parent().parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().addClass('active');
    });
    
    function pulsar(textarea, e, tipoComentario, idParent) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            comentario = $(textarea).val();
            if (comentario !== '') {
                $(textarea).val('');
                agregarComentario('articles', comentario, tipoComentario, idParent);
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
                    var html = '<div class="social-avatar"><a href=""><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a></div>\n\
                    <div class="social-feed-box"><div class="social-avatar"><a href="#">'+result.user_name+'</a><small class="text-muted"> - '+result.tiempo+'</small></div>\n\
                    <div class="social-body"><p>'+result.name+'</p><br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a></div></div><div class="social-footer"><div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a>\n\
                    <div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div></div>';
                    $('#ultimo_comentario').before(html);
                } else if (result.type === 'Answer') {
                    var answer = "\'Answer to Answer\'";
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><div class="btn-group"><a class="btn btn-white btn-xs" onclick="habilitarComentario('+result.id+')"><i class="fa fa-comments"></i> Comentar</a> - <small class="text-muted">'+result.tiempo+'</small></div></div>\n\
                    <div class="social-comment hidden" id="comentario'+result.id+'"><a href="" class="pull-left"> <img alt="image" class="img-circle" src="'+imagenUsuario+'"> </a><div class="media-body"><textarea class="form-control" onkeypress="pulsar(this, event, '+answer+', '+result.id+')" placeholder="Escribe un comentario..."></textarea></div></div></div>';
                    $('#comentario'+result.parent).before(html);
                } else {
                    var html = '<div class="social-comment"><a href="" class="pull-left"><img alt="image" class="img-circle" src="'+imagenUsuario+'"></a><div class="media-body"><a href="#">'+result.user_name+'</a>  '+  result.name+'<br><small class="text-muted">'+result.tiempo+'</small></div></div>';
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
@include('layouts._script_spinner_code')
@endsection