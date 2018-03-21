<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>{{ $title }}</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>

        </div>
    </div>
    <div class="ibox-content">
        <table class="table table-striped table-bordered table-hover dataTables-related" >
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de creación</th>
                    <th>Creado por</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elements as $element)
                <tr class="gradeX">
                    <td>{{ $element->name }}</td>
                    <td>{{ $element->description }}</td>
                    <td>{{ $element->created_at }}</td>
                    <td>{{ $element->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de creación</th>
                    <th>Creado por</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@if ($nroTable === '1')
<script>
    $(function () {
        $('.dataTables-related').DataTable({
            pageLength: 10,
            responsive: true,
            scrollCollapse: true,
            language: {
                lengthMenu:   "Mostrar _MENU_ registros por página",
                zeroRecords:  "No se ha encontrado",
                info:         "Página _PAGE_ de _PAGES_",
                infoEmpty:    "Registros no disponibles",
                search:       "",
                paginate: {
                    first:      "Primero",
                    last:       "Ultimo",
                    next:       " Siguiente ",
                    previous:   " Anterior "
                },
                infoFiltered: "(filtrando de _MAX_ registros)"
            }
        });
        $('div.dataTables_filter input').addClass('slds-input');
        $('div.dataTables_filter input').attr("placeholder","Buscar");
    });
    
    function minificarTablas() {
        var tablas = $('.collapse-link');
        for (var i=0; i<tablas.length; ++i) {
            if (i>0) {
                if (tablas[i].children[0].attributes[0].nodeValue === 'fa fa-chevron-up') {
                    tablas[i].click();
                }
            }
        }
    }
</script>
@endif