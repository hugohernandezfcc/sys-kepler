@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <input type="hidden" id="typeView" value="{{ $typeView }}">
    <div class="col-sm-6">
        @if($typeView == 'takeexam')
            <h2>Examen</h2>
        @elseif($typeView == 'taketask')
            <h2>Tarea</h2>
        @endif
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'takeexam')
            <li>
                Tomar examen
            </li>
            <li class="active">
                <strong>{{ $record->name }}</strong>
            </li>
            @elseif($typeView == 'taketask')
            <li>
                Tomar tarea
            </li>
            <li class="active">
                <strong>{{ $record->name }}</strong>
            </li>
            @endif
        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView == 'takeexam')
        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>
        @elseif($typeView == 'taketask')
        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>
        @endif
    </div>
</div>



@if($typeView == 'takeexam')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <h2>Examen: {{$record->name}}</h2>
                    </div>
                    <h4>Descripción del examen:</h4>
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
                        <dt>Grupo:</dt> <dd>{{ $to_related->group->name }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" role='form' action="/applytests/storeanswers" id="form-create" class="form-horizontal" disabled>
                        {{ csrf_field() }}
                        <input type="hidden" id="examId" name="examId" value="{{ $record->id }}">
                        <input type="hidden" id="groupId" name="groupId" value="{{ $to_related->group->id }}">
                        @foreach ($items_exam as $item_exam)
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div id="questionId-{{ $item_exam->id }}" class="questionTest">
                                    <input type="hidden" name="question{{ $item_exam->id }}" value="{{ $item_exam->id }}">
                                    <div class="col-sm-12">
                                        <h3> {{ $item_exam->name }} </h3>
                                    </div>
                                    @php ($totalOption = count($item_exam->children()->where('type', '=', 'Question')->get()))
                                    @foreach ($item_exam->children()->where('type', '=', 'Question')->get() as $key => $detalle)
                                        @if ($detalle->subtype === 'Open')
                                            <div class="form-group" id="typeQuestion1">
                                                <label class="col-sm-2 control-label small">Responda brevemente</label>
                                                <div class="col-sm-10"><textarea name="Open-question{{ $item_exam->id }}" class="form-control"></textarea> </div>
                                            </div>
                                        @elseif ($detalle->subtype === 'Single option')
                                            @if ($key == 0)
                                            <div class="form-group">    
                                                <label class="col-sm-2 control-label small">Seleccione una opción</label>
                                                <div class="col-sm-10">
                                            @endif
                                                    <div class="radio">
                                                        <input type="radio" name="Single-question{{ $item_exam->id }}" id="Single-question{{ $item_exam->id }}-option{{ $detalle->id }}" value="{{ $detalle->id }}">
                                                        <label for="Single-question{{ $item_exam->id }}-option{{ $detalle->id }}">
                                                            {{ $detalle->name }}
                                                        </label>
                                                    </div>
                                            @if (($key+1) == $totalOption)
                                                </div>
                                            </div>
                                            @endif
                                        @else
                                            @if ($key == 0)
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label small">Seleccione una o varias opciones</label>
                                                <div class="col-sm-10">
                                            @endif
                                                    <div class="checkbox checkbox-success">
                                                        <input id="Multiple-question{{ $item_exam->id }}-option{{ $detalle->id }}" name="Multiple-question{{ $item_exam->id }}-option{{ $detalle->id }}" type="checkbox">
                                                        <label for="Multiple-question{{ $item_exam->id }}-option{{ $detalle->id }}">
                                                            {{ $detalle->name }}
                                                        </label>
                                                    </div>
                                            @if (($key+1) == $totalOption)
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif($typeView == 'taketask')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <h2>Tarea: {{$record->name}}</h2>
                    </div>
                    <h4>Descripción de la actividad:</h4>
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
                        <dt>Grupo:</dt> <dd>{{ $to_related->group->name }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="post" role='form' action="/applytasks/storeanswers" id="form-create" class="form-horizontal" disabled>
                        {{ csrf_field() }}
                        <input type="hidden" id="taskId" name="taskId" value="{{ $record->id }}">
                        <input type="hidden" id="groupId" name="groupId" value="{{ $to_related->group->id }}">
                        <input type="hidden" id="response" name="response{{ $record->id }}">
                        <div class="form-group" id="typeQuestion1">
                            <label class="col-sm-2 control-label small">Responda</label>
                            <div class="col-sm-10"><textarea id="editor" class="form-control"></textarea> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('editor');
        CKEDITOR.instances.editor.on("change", function() {
            $('#response').val(CKEDITOR.instances.editor.getData());
        });
    });
    
</script>
@endsection