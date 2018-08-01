<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        <div role="form" class="navbar-form-custom">
            <div class="form-group">
                <input type="text" placeholder="¿Buscas algo?" onkeypress="globalSearch(event)" class="form-control input-sm" name="topSearch" id="topSearch">
            </div>
        </div>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <span class="m-r-sm text-muted welcome-message">Bienvenido {{ Auth::user()->name }}</span>
        </li>
        @if (Auth::user()->type !== "master")
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
            </a>
            <ul class="dropdown-menu dropdown-messages">
                <li>
                    <div class="dropdown-messages-box">
                        <a href="profile.html" class="pull-left">
                            <img alt="image" class="img-circle" src="inspinia/img/a7.jpg">
                        </a>
                        <div class="media-body">
                            <small class="pull-right">46h ago</small>
                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
                <li>
                    <div class="dropdown-messages-box">
                        <a href="profile.html" class="pull-left">
                            <img alt="image" class="img-circle" src="inspinia/img/a4.jpg">
                        </a>
                        <div class="media-body ">
                            <small class="pull-right text-navy">5h ago</small>
                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
                <li>
                    <div class="dropdown-messages-box">
                        <a href="profile.html" class="pull-left">
                            <img alt="image" class="img-circle" src="inspinia/img/profile.jpg">
                        </a>
                        <div class="media-body ">
                            <small class="pull-right">23h ago</small>
                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class="divider"></li>
                <li>
                    <div class="text-center link-block">
                        <a href="mailbox.html">
                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                        </a>
                    </div>
                </li>
            </ul>
        </li>
        @endif
        <li class="dropdown">
            <a class="dropdown-toggle count-info" id="siteFav" data-toggle="dropdown" href="#">
                <i class="fa fa-star-o"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts" id="miniListFav">
                <li>
                    <div class="text-center link-block" id="addDelFav">
                        <a href="#confirmFavorites" data-toggle="modal" data-target="#confirmFavorites">
                            <i class="fa fa-star"></i>
                            <strong>Agregar a favoritos</strong>
                        </a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<div class="modal fade" id="confirmFavorites" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Confirmar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" id="nameFavorite" class="form-control" maxlength="150" required>
                            <span id="namefav-error" class="hidden span-error">Por favor coloque un nombre.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="buttonConfirmDelete" onclick="addFavorites()" class="btn btn-primary primary">Aceptar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="listFavorites" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Mis favoritos</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableFavorites">
                        <thead>
                            <tr>
                                <th>Tipo </th>
                                <th>Nombre </th>
                                <th>Enlace </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarFavorites(result) {
        var iconSiteFav = '<i class="fa fa-star-o"></i>'
        var link = $(location).attr('href').replace("#", "");
        var minilist = '';
        var boton = '<li><div class="text-center link-block"><a href="#confirmFavorites" data-toggle="modal" data-target="#confirmFavorites"><i class="fa fa-star"></i> <strong> Agregar a favoritos</strong></a></div></li>';
        var favorites = result.favorites;
        if (!$.isEmptyObject(favorites)) {
            $('#tableFavorites tbody tr').remove();
            for (var type in favorites) {
                let icon = iconFav(favorites[type][0].domain);
                var register = '<tr><td rowspan="' + favorites[type].length + '">' + icon + ' ' +  type + '</td>';
                
                for (var i = 0; i < favorites[type].length; i++) {
                    if (i < 1) {
                        let icon = iconFav(favorites[type][i].domain);
                        minilist += '<li><a href="#listFavorites" data-toggle="modal" data-target="#listFavorites"><div>'+icon+' '+favorites[type].length+' '+type+'<span class="pull-right text-muted small">'+favorites[type][i].time+'</span></div></a></li><li class="divider"></li>';
                    } else {
                        register += '<tr>';
                    }
                    register += '<td>' + favorites[type][i].name +'</td>';
                    register += '<td><a href="' + favorites[type][i].link +'">' + favorites[type][i].link +'</td></tr>';

                    if (favorites[type][i].link == link ) {
                        iconSiteFav = '<i class="fa fa-star"></i>';
                        boton = '<li><div class="text-center link-block"><a href="#" onclick="deleteFavorites()"><i class="fa fa-star-o"></i> <strong> Quitar de favoritos</strong></a></div></li>';
                    }
                }
                $('#tableFavorites tbody').append(register);
            }
        }
        minilist += boton; 
        $('#miniListFav').html(minilist);
        $('#siteFav').html(iconSiteFav); 
    }

    $(function () {
        $.ajax({
            url: "/favorites/index",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                mostrarFavorites(result);
            },
            error: function () {
            //alert("fallo");
            }
        });
    });

    function iconFav(domain) {
        switch(domain) {
            case 'home':
                return '<i class="fa fa-home"></i>';
            case 'groups':
                return '<i class="fa fa-group"></i>';
            case 'courses':
                return '<i class="fa fa-university"></i>';
            case 'areas':
                return '<i class="fa fa-subscript"></i>';
            case 'profile':
                return '<i class="fa fa-user-plus"></i>';
            case 'subjects':
                return '<i class="fa fa-graduation-cap"></i>';
            case 'task':
                return '<i class="class="fa fa-tasks""></i>';
            case 'test':
                return '<i class="fa fa-flask"></i>';
            case 'list':
                return '<i class="fa fa-list"></i>';
            case 'modules':
                return '<i class="fa fa-archive"></i>';
            case 'links':
                return '<i class="fa fa-link"></i>';
            case 'articles':
                return '<i class="fa fa-sticky-note-o"></i>';
            case 'forums':
                return '<i class="fa fa-clone"></i>';
            case 'walls':
                return '<i class="fa fa-cubes"></i>';
            default:
                return '<i class="fa fa-home"></i>';
        }
    }

    function addFavorites() {
        if ($('#nameFavorite').val() === '') {
            $('#namefav-error').removeClass('hidden');
            return false;
        } else {
            $('#namefav-error').addClass('hidden');
            $.ajax({
                url: "/favorites/store",
                data: { 
                    "name":$('#nameFavorite').val(),
                    "link":$(location).attr('href').replace("#", ""),
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                method: "POST",
                success: function(result)
                {
                    mostrarFavorites(result);
                    $('#confirmFavorites').modal('hide');
                },
                error: function () {
                //alert("fallo");
                }
            });
        }
    }

    function deleteFavorites() {
        $.ajax({
            url: "/favorites/destroy",
            data: {
                "link":$(location).attr('href').replace("#", ""),
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            method: "POST",
            success: function(result)
            {
                mostrarFavorites(result);
            },
            error: function () {
            //alert("fallo");
            }
        });
    }
</script>