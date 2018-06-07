<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kepler</title>

    <!-- Styles -->
    <link href="{{ asset('inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/dualListbox/bootstrap-duallistbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/cropperjs/cropper.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <script src="{{ asset('inspinia/js/jquery-3.1.1.min.js') }}"></script>
</head>


<body>
    <div id="app">
        <div id="wrapper">
            @include('leftmenu')
            <div id="page-wrapper" class="gray-bg dashbard-1">
                @include('topmenu')
                
                @yield('content')

                @include('layouts._modal_global_search')

                @include('layouts._script_spinner_code', ['call' => 'exists'])
                <!-- @include('footer') -->
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Scripts Menú -->
    <script src="{{ asset('inspinia/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.time.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('inspinia/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('inspinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    
    <!-- Jasny -->
    <script src="{{ asset('inspinia/js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- EayPIE -->
    <script src="{{ asset('inspinia/js/plugins/easypiechart/jquery.easypiechart.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('inspinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('inspinia/js/demo/sparkline-demo.js')}}"></script>

    <!-- Select2 -->
    <script src="{{ asset('inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

    <!-- Image cropper -->
    <script src="{{ asset('inspinia/js/plugins/cropperjs/cropper.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/cropperjs/jquery-cropper.js') }}"></script>

    <!-- Steps -->
    <script src="{{ asset('inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('inspinia/js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            var url = jQuery(location).attr('href').split('/')[3];
            if (url === 'home') {
                $('#side-menu li.active').removeClass('active');
                $("#side-menu [href='/']").parent().addClass('active');
            } else if (url === 'groups' || url === 'courses' || url === 'areas') { 
                $('#side-menu li.active').removeClass('active');
                $("#side-menu [href='/" + url +"']").parent().addClass('active');
            } else if (url === 'profile') {
                var aux = jQuery(location).attr('href').split('/')[4];
                if (aux === 'inscriptions') {
                    $('#side-menu li.active').removeClass('active');
                    $("#side-menu [href='/profile/inscriptions']").parent().addClass('active');
                }
            }
            /*$("#topSearch").focus(function(){
                $(this).css("border", "1px solid green");
            });
            
            $("#topSearch").focusout(function(){
                if($(this).val() == '') {
                    $(this).css("border", "");
                }
            });*/

            $("#resultSearch").on('hidden.bs.modal', function () {
                $('#resultSearch div.one-result').remove();
            });

            jQuery.extend(jQuery.validator.messages, {
                empty: "Por favor agregue elementos para continuar",
                required: "Este campo es obligatorio.",
                remote: "Por favor, rellena este campo.",
                email: "Por favor, escribe una dirección de correo válida",
                url: "Por favor, escribe una URL válida.",
                date: "Por favor, escribe una fecha válida.",
                dateISO: "Por favor, escribe una fecha (ISO) válida.",
                number: "Por favor, escribe un número entero válido.",
                digits: "Por favor, escribe sólo dígitos.",
                creditcard: "Por favor, escribe un número de tarjeta válido.",
                equalTo: "Por favor, escribe el mismo valor de nuevo.",
                accept: "Por favor, escribe un valor con una extensión aceptada.",
                maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
                minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
                rangelength: jQuery.validator.format("Por favor, escribe entre {0} y {1} caracteres."),
                range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
                max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
                min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
            });
        });

        function globalSearch(e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                var search = $('#topSearch').val();
                if (search !== '') {
                    $('#topSearch').val('');
                    busqueda(search);
                }
            }

            function busqueda(search) {
                $.ajax({
                    url: "/home/search",
                    data: { 
                        "search":search,
                        "_token": "{{ csrf_token() }}"
                        },
                    dataType: "json",
                    method: "POST",
                    success: function(result)
                    {
                        var globalResult = result.globalResult;
                        if (!$.isEmptyObject(globalResult)) {
                            for (var clave in globalResult){
                                if (globalResult.hasOwnProperty(clave)) {
                                    var fCreated = new Date(globalResult[clave].created_at);
                                    var fUpdated = new Date(globalResult[clave].updated_at);
                                    var dateCreated = fCreated.getDate() + '-' + (fCreated.getMonth()+1) + '-' + fCreated.getFullYear();
                                    var dateUpdated = fUpdated.getDate() + '-' + (fUpdated.getMonth()+1) + '-' + fUpdated.getFullYear();
                                    var html = '<div class="row one-result"><div class="col-lg-12"><div class="ibox collapsed"><div class="ibox-title"><h5>' + globalResult[clave].name + '</h5><div class="ibox-tools"><a class="collapse-link">\n\
                                        <i class="fa fa-chevron-up"></i></a></div></div><div class="ibox-content"><div class="col-lg-3"><strong>Creado:</strong> ' + dateCreated + '</div><div class="col-lg-3">\n\
                                        <strong>Actualizado:</strong> ' + dateUpdated + '</div><div class="col-lg-6"><strong>Creado por:</strong> ' + globalResult[clave].created_by + '</div></div></div></div></div>';
                                    $('#contentSearch').after(html);
                                }
                            }
                        } else {
                            var html = '<div class="row one-result"><div class="col-lg-12"><div class="ibox collapsed"><div class="ibox-title"><h5> No hay resultados para la busqueda "' + search + '"</h5></div></div></div></div>';
                            $('#contentSearch').after(html);
                        }
                        $('#resultSearch').modal('show');
                    },
                    error: function () {
                        //alert("fallo");
                    }
                });
            }
        }
        
        var data2 = [
                [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var data3 = [
                [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
            ];

        var dataset = [
                {
                    label: "Ganancias",
                    data: data3,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: 24 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Ingresos",
                    data: data2,
                    yaxis: 2,
                    color: "#1C84C6",
                    lines: {
                        lineWidth:1,
                            show: true,
                            fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.4
                            }]
                        }
                    },
                    splines: {
                        show: false,
                        tension: 0.6,
                        lineWidth: 1,
                        fill: 0.1
                    },
                }
            ];


            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    max: 1070,
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }, {
                    position: "right",
                    clolor: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 67
                }
                ],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null, previousLabel = null;

            if(document.getElementById('flot-dashboard-chart'))
                $.plot($("#flot-dashboard-chart"), dataset, options);
            
            $("#costosChar").css("opacity", 0.2);
            $("#botonCostos").removeClass("hidden");

            $(function(){
                $('.dataTables-example').DataTable({
                    pageLength: 10,
                    responsive: true,
                    language: {
                        lengthMenu:   "Mostrar _MENU_ registros por página.",
                        zeroRecords:  "No se ha encontrado",
                        info:         "Página _PAGE_ de _PAGES_",
                        infoEmpty:    "Registros no disponibles",
                        search:       "&nbsp; Buscar&nbsp;",
                        paginate: {
                            first:      "Primero",
                            last:       "Ultimo",
                            next:       " Siguiente ",
                            previous:   " Anterior "
                        },
                        infoFiltered: "(buscando de _MAX_ total registros)"
                    },
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [
                        {extend: 'copy'},
                        {extend: 'csv'},
                        {extend: 'excel', title: 'Datos_kepler'},
                        {extend: 'pdf', title: 'Datos_kepler'},
                        {extend: 'print',
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                            }
                        }
                    ]
                });
            });

    </script>


</body>
</html>
