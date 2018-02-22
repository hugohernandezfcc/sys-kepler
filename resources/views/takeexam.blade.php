@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <input type="hidden" id="typeView" value="{{ $typeView }}">
    <div class="col-sm-6">
        <h2>Examen</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'takeexam')
            <li>
                <strong>Tomar examen</strong>
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
        @endif
    </div>
</div>



@if($typeView == 'takeexam')
<input type="hidden" id="idRecord" value="{{ $record->id }}">
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="ibox">
        <div class="ibox-content">
                
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        <a href="/home" class="btn btn-white btn-xs pull-right"> <i class="fa fa-chevron-left"></i> Regresar</a>
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
                        <dt>Grupo:</dt> <dd>{{ $record->groups()->where('exam_id', '=', $record->id)->first()->name }}</dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @foreach ($items_exam as $item_exam)
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3> {{ $item_exam->name }} </h3>
                        </div>
                        <div class="">
                        @foreach ($item_exam->children()->where('type', '=', 'Question')->get() as $key => $answer)
                        
                            @if ($answer->subtype === 'Open')
                                <label class="col-sm-2 control-label">Responda brevemente</label>
                                <div class="col-sm-10"><textarea id="answer1" class="form-control"></textarea> </div>
                            @elseif ($answer->subtype === 'Single option')
                                @if ($key === 0)
                                    <label class="col-sm-2 control-label">Seleccione una opción</label>
                                @else
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
                                @else
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
@endsection