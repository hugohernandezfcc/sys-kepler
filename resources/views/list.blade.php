@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <h2>Lista</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'form')
            <li class="active">
                <strong>Pases de lista</strong>
            </li>
            @elseif($typeView == 'view')
            <li>
                Pase de lista
            </li>
            <li class="active">
                <strong>Lista {{ $record->name }}</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-4">
        @if($typeView == 'view')
        <div class="title-action">
            <button type="submit" form="form-create" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </button>
        </div>
        @endif
    </div>
</div>



@if($typeView == 'view') 
<br/>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12 animated fadeInRight">
            <div class="ibox-title">
                <h5>Registra la información <small>asistentes.</small></h5>
                <div class="ibox-tools">
                    <a href="/list">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                @include('layouts._spinner_code')
                <form method="post" action="/list/store" id="form-create" class="form-horizontal">
                    {{ csrf_field() }}
                    <input type="hidden" name="idRecord" value="{{ $record->id }}">
                    <div class="mail-box">
                        <table class="table table-hover table-mail">
                            <thead>
                                <tr>
                                    <th>Asistió</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record->users as $user)
                                <tr class="read">
                                    <td class="check-mail">
                                        <input type="checkbox" class="i-checks" name="{{ $user->id }}">
                                    </td>
                                    <td class="client-avatar"><img alt="image"  class="img-circle" src="{{ asset('uploads/avatars/'. $user->avatar) }}"> </td>
                                    <td class="mail-subject">{{ $user->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Asistió</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- iCheck -->
<script src="{{ asset('inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
    });
</script>
@elseif($typeView == 'list')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Lista de grupos</h5>
                </div>
                <div class="ibox-content">
                    @include('layouts._spinner_code')

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th> - </th>
                                    <th>Nombre</th>
                                    <th>Inicia en</th>
                                    <th>Finaliza en</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td> 
                                        <a href="/list/show/{{ $rec->id }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i>
                                        </a> 
                                    </td>
                                    <td>{{ $rec->name }}</td>
                                    <td>{{ $rec->start }}</td>
                                    <td>{{ $rec->end }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> - </th>
                                    <th>Nombre</th>
                                    <th>Inicia en</th>
                                    <th>Finaliza en</th>
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
@endif
<script>
    $(function () {
        $('#side-menu li.active').removeClass('active');
        var url = jQuery(location).attr('href').split('/')[3];
        $("#side-menu [href='/" + url +"']").parent().parent().parent().addClass('active');
        $("#side-menu [href='/" + url +"']").parent().addClass('active');
    });
</script>
@include('layouts._script_spinner_code')
@endsection