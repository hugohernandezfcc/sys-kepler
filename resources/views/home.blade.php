@extends('layouts.app')

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-11">
            <h3>Panel de administración</h3>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-subscript"></i> Áreas</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $records['areas'] }}</h1>
                    <small>Total de áreas activas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-graduation-cap"></i> Asignaturas</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $records['subjects'] }}</h1>
                    <small>Asignaturas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-child"></i> Alumnos</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $records['students'] }}</h1>
                    <small>Alumnos activos</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-group"></i> Grupos</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $records['groups'] }}</h1>
                    <small>Grupos</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="costosChar">
                <div class="ibox-title">
                    <h5>Ingresos por ciclo semestral</h5>
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white active">Ciclo actual</button>
                            <button type="button" class="btn btn-xs btn-white">Anual</button>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <ul class="stat-list">
                                <li>
                                    <h2 class="no-margins">2,346</h2>
                                    <small>Inversión</small>
                                    <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins ">4,422</h2>
                                    <small>Total de ingresos</small>
                                    <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins ">9,180</h2>
                                    <small>Ganancias</small>
                                    <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <a id="botonCostos" href="/wizard/costs" class="btn btn-primary btn-position-absolute hidden">Configurar costos</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Usuarios de Kepler</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre </th>
                                    <th>Correo </th>
                                    <th>Fecha de registro </th>
                                    <th>Tipo de usuario </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records['users'] as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td><i class="fa fa-envelope"> </i> {{ $user->email }}</td>
                                    <td>{{ $user->created_at->toFormattedDateString() }}</td>
                                    <td>{{ $user->type }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
