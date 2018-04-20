@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Resultados</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeResult == 'test')
            <li class="active">
                <strong>Resultados del examen</strong>
            </li>
            @elseif($typeResult == 'task')
            <li class="active">
                <strong>Resultados de la tarea</strong>
            </li>
            @endif

        </ol>
    </div>
</div>

@if($typeView == 'list')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @if($typeResult == 'test')
                        <h5>Lista de resultados del examen: {{ $to_related->name }}</h5>
                    @elseif($typeResult == 'task')
                        <h5>Lista de resultados de la actividad: {{ $to_related->name }}</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Grupo</th>
                                    <th>Cantidad de respuestas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $rec)
                                    <tr class="gradeX">
                                        <td> 
                                            <a href="/results/show/{{ $typeResult .'-'. $rec[0]->id_record .'-'. $rec[0]->group_id }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>{{ $rec[0]->group->name }}</td>
                                        <td>{{ count($rec) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Grupo</th>
                                    <th>Cantidad de respuestas</th>
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @if($typeResult == 'test')
                        <h5>Lista de resultados del examen: {{ $to_related->name }}</h5>
                    @elseif($typeResult == 'task')
                        <h5>Lista de resultados de la actividad: {{ $to_related->name }}</h5>
                    @endif
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th rowspan="2">Usuario</th>
                                    <th colspan="2">Resultados</th>
                                </tr>
                                <tr>
                                    @if($typeResult == 'test')
                                    <th>Pregunta</th>
                                    @elseif($typeResult == 'task')
                                    <th>Actividad</th>
                                    @endif
                                    <th>Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $rec)
                                    @foreach ($rec as $collections)
                                        @php($totalAnswers = $collections->count())
                                        @foreach ($collections as $detalle)
                                            <tr class="gradeX">
                                                @if ($loop->first)
                                                    <td rowspan="{{ $totalAnswers }}">{{ $detalle->user->name }}</td>
                                                @endif
                                                <td>{{ $detalle->indication }}</td>
                                                <td>{!! $detalle->answer !!}</td>
                                            </tr>
                                        @endforeach
                                        @if (!$loop->parent->last)
                                            <tr class="gradeX">
                                            <td></td><td></td><td></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th rowspan="2">Usuario</th>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Resultados</th>
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

<script>
    
</script>
@endsection