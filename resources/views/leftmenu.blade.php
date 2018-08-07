
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                        @if (Auth::check())
                            @if (Auth::user()->type !== null)
                                <span>
                                    <img alt="image" id="leftAvatar" class="img-circle" src="{{ asset('uploads/avatars/'. Auth::user()->avatar) }}" width="45%" />
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> 
                                    <span class="block m-t-xs"> <strong class="font-bold">Sys Kepler</strong></span> 
                                    <span class="text-muted text-xs block">Opciones <b class="caret"></b></span>
                                </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="/profile"><i class="fa fa-btn fa-user"></i>  Perfil</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="mailbox.html">Mailbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/logout"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                                </ul>
                            @endif
                        @else
                            <span>
                                <img alt="image" id="leftAvatar" class="img-circle" src="{{ asset('uploads/avatars/default.jpg') }}" width="45%" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear"> 
                                <span class="block m-t-xs"> <strong class="font-bold">Sys Kepler</strong></span>
                            </span>
                        @endif
                    </div>
                    <div class="logo-element">
                        Kepler
                    </div>
                </li>
                <!-- <li class="active">
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="index.html">Dashboard v.1</a></li>
                        <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                        <li><a href="dashboard_3.html">Dashboard v.3</a></li>
                        <li><a href="dashboard_4_1.html">Dashboard v.4</a></li>
                        <li><a href="dashboard_5.html">Dashboard v.5 </a></li>
                    </ul>
                </li> -->
            @if (Auth::check())
                @if (Auth::user()->type == "admin")
                <li><a href="/"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span></a></li>
                <li><a href="/groups"><i class="fa fa-group"></i> <span class="nav-label">Grupos</span></a></li>
                <li><a href="/courses"><i class="fa fa-university"></i> <span class="nav-label">Cursos</span></a></li>
                <li><a href="/areas"><i class="fa fa-subscript"></i> <span class="nav-label">Areas</span></a></li>
                <li><a href="/profile/inscriptions"><i class="fa fa-user-plus"></i> <span class="nav-label">Procesos de inscripción</span></a></li>
                <li>
                    <a href="#"><i class="fa fa-ellipsis-v"></i> <span class="nav-label">Contenidos</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/subjects"><i class="fa fa-graduation-cap"></i> Asignaturas</a></li>
                        <li><a href="/task"><i class="fa fa-tasks"></i> Tareas</a></li>
                        <li><a href="/test"><i class="fa fa-flask"></i> Examenes</a></li>
                        <li><a href="/list"><i class="fa fa-list"></i>  Pase de lista</a></li>
                        <li class="inline"><a href="/modules"><i class="fa fa-archive"></i> Modulos</a></li>
                        <li class="inline">
                            <a href="#" id="damian">&nbsp;<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="/links"><i class="fa fa-link"></i> Enlaces</a></li>
                                <li><a href="/articles"><i class="fa fa-sticky-note-o"></i> Articulos</a></li>
                                <li><a href="/forums"><i class="fa fa-clone"></i> Foro</a></li>
                                <li><a href="/walls"><i class="fa fa-cubes"></i> Muro</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @elseif (Auth::user()->type == "student")
                <li>
                    <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
                </li>
                <li>
                    <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
                </li>
                @elseif (Auth::user()->type == "master")
                    <li class="active"><a href="/"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span></a></li>
                    <li ><a href="/groups"><i class="fa fa-group"></i> <span class="nav-label">Mis grupos</span></a></li>
                    <li ><a href="/subjects"><i class="fa fa-graduation-cap"></i>  <span class="nav-label">Mis asignaturas</span></a></li>
                    <li ><a href="/articles"><i class="fa fa-copy"></i>  <span class="nav-label">Mis artículos</span></a></li>
                    <li ><a href="/forums"><i class="fa fa-question"></i>  <span class="nav-label">Foros</span></a></li>
                    <li ><a href="/calendars"><i class="fa fa-calendar"></i>  <span class="nav-label">Calendario</span></a></li>
                @endif
                <li class="special_link">
                    <a href="/logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Cerrar sesión</span></a>
                </li>
            @endif

                <!-- <li>
                    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">Mailbox </span><span class="label label-warning pull-right">16/24</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="mailbox.html">Inbox</a></li>
                        <li><a href="mail_detail.html">Email view</a></li>
                        <li><a href="mail_compose.html">Compose email</a></li>
                        <li><a href="email_template.html">Email templates</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">E-commerce</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="ecommerce_products_grid.html">Products grid</a></li>
                        <li><a href="ecommerce_product_list.html">Products list</a></li>
                        <li><a href="ecommerce_product.html">Product edit</a></li>
                        <li><a href="ecommerce_product_detail.html">Product detail</a></li>
                        <li><a href="ecommerce-cart.html">Cart</a></li>
                        <li><a href="ecommerce-orders.html">Orders</a></li>
                        <li><a href="ecommerce_payments.html">Credit Card form</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#" id="damian">Third Level <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>

                            </ul>
                        </li>
                        <li><a href="#">Second Level Item</a></li>
                        <li>
                            <a href="#">Second Level Item</a></li>
                        <li>
                            <a href="#">Second Level Item</a></li>
                    </ul>
                </li>
                <li class="landing_link">
                    <a target="_blank" href="landing.html"><i class="fa fa-star"></i> <span class="nav-label">Landing Page</span> <span class="label label-warning pull-right">NEW</span></a>
                </li>
                <li class="special_link">
                    <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">Package</span></a>
                </li> -->
            </ul>

        </div>
    </nav>