@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Perfil</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/home">Kepler</a>
            </li>
            @if($typeView == 'view')
            <li class="active">
                <strong>Perfil</strong>
            </li>
            @elseif($typeView == 'form')
            <li>
                Perfil
            </li>
            <li class="active">
                <strong>Editar datos de perfil</strong>
            </li>
            @elseif($typeView == 'list')
            <li>
                Perfil
            </li>
            <li class="active">
                <strong>Procesos de inscripción activos</strong>
            </li>
            @endif

        </ol>
    </div>
    <div class="col-sm-6">
        @if($typeView == 'view')
        <div class="title-action">
            @if (Auth::user()->type == "admin")
                <a href="/configurations/create" class="btn btn-primary btn-sm">Agregar columna tabla Users</a>
            @endif
            <a href="/profile/edit" class="btn btn-primary btn-sm">Editar mis datos</a>
        </div>

        @elseif($typeView == 'form')

        <div class="title-action">
            <a onclick="document.getElementById('form-update').submit();" class="btn btn-primary btn-sm">
                <i class="fa fa-check"></i> Guardar
            </a>
        </div>
        
        @elseif($typeView == 'list')

        <div class="title-action">
            <a href="/configurations/createinscriptions" class="btn btn-primary btn-sm">Agregar proceso de inscripción</a>
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
                <h5>Edita tu información</h5>
                <div class="ibox-tools">
                    <a href="/profile">
                        Cancelar
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form enctype="multipart/form-data" method="post" action="/profile/update" id="form-update" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group"><label class="col-sm-2 control-label">Nombre</label>

                        <div class="col-sm-10"><input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Correo</label>

                        <div class="col-sm-10"><input type="text" name="email" value="{{ Auth::user()->email }}" disabled="true" class="form-control"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    @foreach ($camposUsers as $column)
                        @php($valorCampo = $column->name)
                        <div class="form-group"><label class="col-sm-2 control-label">{{ucfirst(($column->label != '') ? $column->label : $valorCampo)}}</label>
                            <div class="col-sm-10">
                            @if($column->type == 'string')
                                <input type="text" name="{{$valorCampo}}" class="form-control" value="{{Auth::user()->$valorCampo}}" required>
                            @elseif($column->type == 'integer')
                                <input type="number" name="{{$valorCampo}}" class="form-control" value="{{Auth::user()->$valorCampo}}" required>
                            @else
                                <input type="date" name="{{$valorCampo}}" class="form-control" value="{{date('Y-m-d', strtotime(Auth::user()->$valorCampo))}}" required>
                            @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    @endforeach
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
                    <h5>Lista de procesos de inscripción</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Ruta</th>
                                    <th>Descripción</th>
                                    <th>Fecha de creación</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($records as $rec)

                                <tr class="gradeX">
                                    <td>{{ asset('/register/'.$rec->name) }}</td>
                                    <td>{{ $rec->description }}</td>
                                    <td>{{ $rec->created_at }}</td>
                                    <td>{{ $rec->user->name }}</td>
                                </tr>

                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Ruta</th>
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
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <div class="btn-group">
                                    <img id="profileImage" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}" alt="image" class="img-circle" width="40%"><br>
                                    <a href="#" class="btn btn-primary btn-xs" data-target="#modal" data-toggle="modal">Cambiar imagen</a>
                                </div>
                                <h2>Nombre y apellido: {{Auth::user()->name}}</h2>
                                @foreach ($camposUsers as $column)
                                    @php($valorCampo = $column->name)
                                    @if($column->type == 'string' OR $column->type == 'integer')
                                        {{ucfirst(($column->label != '') ? $column->label : $valorCampo)}}: {{Auth::user()->$valorCampo}} <br>
                                    @else
                                        @if(Auth::user()->$valorCampo !== null)
                                            {{ucfirst(($column->label != '') ? $column->label : $valorCampo)}}: {{date('d-m-Y', strtotime(Auth::user()->$valorCampo))}} <br>
                                        @else
                                            {{ucfirst(($column->label != '') ? $column->label : $valorCampo)}}: <br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Cambiar imagen de perfil</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="container-crop">
                                                <img id="image" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}" alt="Picture">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <br>
                                            <h4>Vista previa</h4>
                                            <br>
                                            <div class="img-preview img-preview-sm img-circle"></div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="btn-group">
                                                <label title="Subir imagen" for="inputImage" class="btn btn-primary">
                                                    <input type="file" accept="image/*" name="file" id="inputImage" name="inputImage" class="hide">
                                                    Subir nueva imagen
                                                </label>
                                            </div>
                                            <br>
                                            <br>
                                            <button type="button" class="btn btn-primary" id="saveImageCrop">Cortar y guardar</button>
                                            <br>
                                            <br>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar sin modificar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        var $image = document.getElementById('image');
        var cropBoxData;
        var canvasData;
        var cropper;
        $('#modal').on('shown.bs.modal', function () {
            cropper = new Cropper($image, {
                autoCropArea: 0.5,
                preview: ".img-preview",
                aspectRatio: 1,
                ready: function () {
                    // Strict mode: set crop box data first
                    cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                }
            });
            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {

                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            cropper.reset().replace(this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }
        }).on('hidden.bs.modal', function () {
            cropBoxData = cropper.getCropBoxData();
            canvasData = cropper.getCanvasData();
            cropper.destroy();
        });
        $('#saveImageCrop').on('click', function () {
            $('#saveImageCrop').before('<button class="buttonload btn btn-primary" disabled><i class="fa fa-spinner fa-spin"></i> Guardando</button>');
            $('#saveImageCrop').addClass("hidden");
            $('#modal .btn-primary').attr('disabled', true);
            $('#modal .btn-default').attr('disabled', true);
            // Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`
            cropper.getCroppedCanvas().toBlob(function (blob) {
                var formData = new FormData();

                formData.append('avatar', blob);
                formData.append('_token', "{{ csrf_token() }}");

                // Use `jQuery.ajax` method
                $.ajax('/profile/saveImage', {
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (result) {
                    $('#leftAvatar').attr("src", result.ruta);
                    $('#profileImage').attr("src", result.ruta);
                    $('#image').attr("src", result.ruta);
                    $('#modal .btn-primary').attr('disabled', false);
                    $('#modal .btn-default').attr('disabled', false);
                    $('#saveImageCrop').removeClass("hidden");
                    $('.buttonload').remove();
                    location.reload();
                },
                error: function () {
                    console.log('Upload error');
                }
                });
            });
        });
    });
</script>

@endif
@endsection