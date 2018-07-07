@extends('layouts.app')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-3">
            <div class="widget style1">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <i class="fa fa-trophy fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> ROI </span>
                        <h2 class="font-bold">$ 10,730</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-fa-group fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Grupos asignados </span>
                        <h2 class="font-bold">{{ $records['groups'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-envelope-o fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Nuevos mensajes </span>
                        <h2 class="font-bold">{{ $records['comments'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="widget style1 yellow-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-wechat fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Nuevas dudas </span>
                        <h2 class="font-bold">{{ $records['questions'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="widget-head-color-box navy-bg p-lg text-center">
                <div class="m-b-md">
                    <h2 class="font-bold no-margins">
                        {{Auth::user()->name}}
                    </h2>
                    <small>Docente de español</small>
                </div>
                <img id="profileImage" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}" alt="image" class="img-circle circle-border m-b-md" width="40%">
                <div>
                    <span>100 Respuestas</span> |
                    <span>350 Seguidores</span> |
                    <span>{{ $records['articles'] }} Artículos</span>
                </div>
            </div>
            <div class="widget-text-box">
                <h4 class="media-heading">{{Auth::user()->name}}</h4>
                <p>Docente con más de 10 años de experiencia en la docencía</p>
                <div class="text-right">
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="widget navy-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-shield fa-4x"></i>
                    <h1 class="m-xs">10</h1>
                    <h3 class="font-bold no-margins">
                        Certificados
                    </h3>
                </div>
            </div>
            <div class="widget  p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-flash fa-4x"></i>
                    <h1 class="m-xs">{{ $records['students'] }}</h1>
                    <h3 class="font-bold no-margins">
                        Estudiantes 
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget lazur-bg p-xl">
                <ul class="list-unstyled m-t-md">
                    <li>
                        <span class="fa fa-envelope m-r-xs"></span>
                        <label>Email:</label>
                        {{Auth::user()->name}}
                    </li>
                    <li>
                        <span class="fa fa-home m-r-xs"></span>
                        <label>Dirección:</label>
                        calle 200, Avenue 10
                    </li>
                    <li>
                        <span class="fa fa-phone m-r-xs"></span>
                        <label>Teléfono:</label>
                        (+121) 678 3462
                    </li>
                </ul>
            </div>
            <div class="widget red-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-bell fa-4x"></i>
                    <h1 class="m-xs">47</h1>
                    <h3 class="font-bold no-margins">
                        Examenes
                    </h3>
                    <small>Por revisar</small>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="widget yellow-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-thumbs-up fa-4x"></i>
                    <h1 class="m-xs">520</h1>
                    <h3 class="font-bold no-margins">
                        Likes
                    </h3>
                    <small></small>
                </div>
            </div>
            <div class="widget navy-bg p-lg text-center">
                <div class="m-b-md">
                    <i class="fa fa-warning fa-4x"></i>
                    <h1 class="m-xs">17</h1>
                    <h3 class="font-bold no-margins">
                        Alumnos 
                    </h3>
                    <small>Sin revisar</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection