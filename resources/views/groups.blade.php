@extends('layouts.app')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
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
        <div class="col-sm-8">
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
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">2 nuevos miembro</span>
                            <h5>Inglés Avanazado</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a1.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a5.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a6.jpg')}}"></a>
                            </div>
                            <h4>Ingles C1</h4>
                            <p>
                                Es capaz de comprender una amplia variedad de textos extensos y con cierto nivel de exigencia, así como reconocer en ellos sentidos implícitos. Sabe expresarse de forma fluida y espontánea sin muestras muy evidentes de esfuerzo para encontrar la expresión adecuada.
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
                                    12
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
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Francés Avanazado</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a5.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a6.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                            </div>
                            <h4>Francés C2</h4>
                            <p>
                                Es capaz de comprender con facilidad prácticamente todo lo que oye o lee. Sabe reconstruir la información y los argumentos procedentes de diversas fuentes, ya sean en lengua hablada o escrita, y presentarlos de manera coherente y resumida.
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">32%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 32%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    24
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    3th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">Roi</div>
                                    $190,325 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>IT-07 - Finance Team</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                            </div>
                            <h4>Info about Design Team</h4>
                            <p>
                                Uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </p>
                            <div>
                                <span>Status of current project:</span>
                                <div class="stat-percent">73%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 73%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    11
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    6th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $560,105 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Castellano</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a1.jpg')}}"></a>
                            </div>
                            <h4>B2 (Intermedio alto)</h4>
                            <p>
                                Es capaz de entender las ideas principales de textos complejos que traten de temas tanto concretos como abstractos, incluso si son de carácter técnico siempre que estén dentro de su campo de especialización.
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">61%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 61%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    43
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    29
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $705,913 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">0 miembros nuevos</span>
                            <h5>NAHUATL</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a1.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a6.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                            </div>
                            <h4>Nahuatl A1</h4>
                            <p>
                                Puede presentarse a sí mismo y a otros, pedir y dar información personal básica sobre su domicilio, sus pertenencias y las personas que conoce. Puede relacionarse de forma elemental siempre que su interlocutor hable despacio y con claridad y esté dispuesto a cooperar.
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">miembros</div>
                                    8
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    7th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $40,200 <i class="fa fa-level-down text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>IT-08 - Lorem ipsum Team</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a1.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                            </div>
                            <h4>Info about Design Team</h4>
                            <p>
                                Many desktop publishing packages and web page editors now use Lorem Ipsum as their. ometimes by accident, sometimes on purpose (injected humour and the like).
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">25%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 25%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    25
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    4th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $140,105 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-title">

                            <h5>Alemán Avanzado</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}"></a>
                            </div>
                            <h4>B2 (Intermedio alto)</h4>
                            <p>
                                Sabe reconstruir la información y los argumentos procedentes de diversas fuentes, ya sean en lengua hablada o escrita, y presentarlos de manera coherente y resumida. 
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">82%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 82%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    68
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    56
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $701,400 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>IT-06 - Standard  Team</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a1.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a4.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                            </div>
                            <h4>Info about Design Team</h4>
                            <p>
                                Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">26%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 26%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    16
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    8th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $160,100 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>IT-09 - Modern Team</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a2.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a3.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a8.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a6.jpg')}}"></a>
                                <a href="#"><img alt="member" class="img-circle" src="{{ asset('inspinia/img/a7.jpg')}}"></a>
                            </div>
                            <h4>Info about Design Team</h4>
                            <p>
                                Words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in.
                            </p>
                            <div>
                                <span>Progreso del curso:</span>
                                <div class="stat-percent">18%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 18%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row  m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">Miembros</div>
                                    53
                                </div>
                                <div class="col-sm-4">
                                    <div class="font-bold">Calificación</div>
                                    9th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">ROI</div>
                                    $60,140 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function removerUsuario(idUsuario) {
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