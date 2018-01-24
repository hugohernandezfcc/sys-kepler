@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>Grupos</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/home">Kepler</a>
                </li>
                @if($typeView != 'form')
                    <li class="active">
                        <strong>Grupos de la organización</strong>
                    </li>
                @elseif($typeView == 'form')
                    <li>
                        Grupos de la organización
                    </li>
                    <li class="active">
                        <strong>Crear grupo</strong>
                    </li>
                @endif

            </ol>
        </div>
        <div class="col-sm-6">
            @if($typeView != 'form')
                <div class="title-action">
                    <a href="/groups/create" class="btn btn-primary btn-sm">Agregar Grupo</a>
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
                        <h5>Registra la información <small>Grupos.</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="/groups">
                                Cancelar
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" action="/groups/store" id="form-create" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre del grupo</label>
                                <div class="col-sm-10"><input type="text" name="name" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-10"><textarea name="description" class="form-control"></textarea> </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <!-- Lista de usuarios -->
                            <div class="input">
                                <input type="text" placeholder="Buscar usuario " title="Escriba un nombre" id="buscar_usuario" onkeyup="buscarUsuario()" class="input form-control">
                            </div>
                            <div class="clients-list">
                            <ul class="nav nav-tabs">
                                <span class="pull-right small text-muted">{{ count($to_related) }} usuarios</span>
                                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Usuarios</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tabla_usuarios">
                                                <tbody>
                                                    @foreach ($to_related as $to)
                                                        <tr id="{{$to->id}}" name="{{$to->id}}">
                                                            <!-- <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td> -->
                                                            <td>{{ $to->name }}</td>
                                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                            <td>{{ $to->email }}</td>
                                                            <td><button class="btn btn-primary btn-xs" onclick="removerUsuario({{$to->id}})"><i class="fa fa-plus"> </i> Agregar</button></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <input name="users" id="users" type="hidden">
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
                            <h5>Lista de grupos</h5>
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
                                <th>Descripción</th>
                                <th>Fecha de creación</th>
                                <th>Creado por</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach ($records as $rec)
                            
                             <tr class="gradeX">
                                <td> 
                                    <a href="/groups/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i>
                                    </a> 
                                </td>
                                <td>{{ $rec->name }}</td>
                                <td>{{ $rec->description }}</td>
                                <td>{{ $rec->created_at }}</td>
                                <td>Admin</td>
                            </tr>

                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> - </th>
                                <th>Nombre</th>
                                <th>Descripción</th>
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
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">2 nuevos miembro</span>
                            <h5>{{ $record->name }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                @foreach ($record->users as $groupUser)
                                    <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a'. $groupUser->pivot->user_id .'.jpg')}}"> </a>
                                @endforeach
                            </div>
                            <h4>Ingles C1</h4>
                            <p>
                                {{ $record->description }}
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    {{ count($record->users) }}
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    82
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $200,913 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <script>
        lista_usuarios = [];
        function removerUsuario(idUsuario) {
            lista_usuarios.push(idUsuario);
            $('#users').val(lista_usuarios);
            $("#"+idUsuario).remove();
        }

        function buscarUsuario() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("buscar_usuario");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabla_usuarios");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


@endsection