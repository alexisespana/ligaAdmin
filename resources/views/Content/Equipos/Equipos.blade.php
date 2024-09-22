@extends('layouts.inicio')
@section('title', 'Equipos')
@section('css')

    <link rel="stylesheet" href="{{ asset('css/dataTables/dataTables.bootstrap.min.css') }}" type="text/css">
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}">

    <!-- Latest compiled and minified JavaScript -->


@endsection

@section('content')

    <div class="card-header">
        Lista de Equipos


    </div>
    <div class="table-responsive scrollbar">
        <table id="categorias" class="table table-bordered table-striped fs-10 mb-0">
            <thead class="bg-200">
                <tr>
                    <th class="text-900 sort" data-sort="#">#</th>
                    <th class="text-900 sort" data-sort="Nombre">Nombre del Equipo</th>
                    <th class="text-900 sort" data-sort="NomnbreCorto">Nomnbre Corto</th>
                    <th class="text-900 sort" data-sort="NomnbreCorto">Colores</th>
                    <th class="text-900 sort" data-sort="cantEquipos">Cantidad Categoría</th>
                    <th class="text-900 sort" data-sort="cantEquipos">Categorías</th>
                    <th class="text-900 sort" data-sort="cantEquipos">Opciones</th>
                </tr>
            </thead>

            <tbody class="list">

            </tbody>
        </table>

    </div>



@stop
@section('scripts')
    <script src="{{ asset('js/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTables/extensions/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('js/sweetAlert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap-select/bootstrap-select.min.js') }}"></script>

    <script>
        dataTableCategorias(true);

        function dataTableCategorias(params) {
            var token = $("input[name=_token]").val();


            $('#categorias').DataTable({
                destroy: true,
                processing: true,
                searching: true,
                serverSide: params,

                order: [
                    [0, "asc"]
                ],
                dom: "<'form-group row'>" +
                    "<'row justify-content-around'<'col-md-4 col-sm-4'l><'col-md-3 col-sm-3'B><'col-md-3 col-sm-3'f>>" +
                    "<'row'tr>" +
                    "<'row justify-content-around pt-3'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",

                buttons: [{
                    text: 'Crear Equipo',
                    attr: {
                        'title': 'Crear Equipo',
                        'class': 'btn btn-falcon-success btn-sm',

                    },
                    action: function() {
                        AgregarEquipos();
                    }
                }],

                select: true,
                paging: true,
                ajax: {
                    "url": "{{ route('datatables-equipos') }}",
                    "type": "POST",
                    "data": {
                        "_token": token,
                    }
                },
                columns: [{
                        data: 'INDEX',
                        name: 'INDEX',
                        // visible: false,
                        searchable: false,
                    },


                    {
                        data: 'NOMBRE',
                        name: 'NOMBRE',
                        class: 'text-nowrap nombre',
                        render: function(data, type, td, row) {
                            data =
                                ' <div class="d-flex align-items-center">' +
                                ' <div class = "avatar avatar-xl" >' +
                                '<img class = "rounded-circle" src = "' + td.ESCUDO + '" alt = "" / >' +
                                '</div>' +
                                '<div class="ms-2">' + data + '</div></div>';
                            return data;
                        },
                    },
                    {
                        data: 'ALIAS',
                        name: 'ALIAS',
                    },
                    {
                        data: 'COLOR1',
                        name: 'COLOR1',
                        render: function(data, type, td, row) {

                            data = '<div class="text-white" >' +
                                '<span class="my-3 p-2" style="background-color: ' + td.COLOR1 +
                                ' !important">' + data.toUpperCase() + '</span>' +
                                '<span class="my-3 p-2" style="background-color: ' + td.COLOR2 +
                                ' !important">' + td.COLOR2.toUpperCase() + '</span>' +
                                '</div>';
                            return data;
                        }
                    },

                    {
                        data: 'CANTIDAD_CATEGORIA',
                        name: 'CANTIDAD_CATEGORIA',
                    },
                    {
                        data: 'CATEGORIAS',
                        name: 'CATEGORIAS',
                    },
                    {
                        data: 'BUTTONS',
                        name: 'BUTTONS',
                        visible: true,
                    },


                ],
                columnDefs: [{

                    targets: [1],
                    width: '30%',

                    targets: [3],
                    width: '10%',

                }],
            });
        }
        const AgregarEquipos = () => {
            $('#titleModal').empty().html('Agregar Nuevo Equipo');
            axios.get("{{ route('view-agregar-equipos') }}")
                .then(response => {
                    $('.modal').modal('show');
                    $('.modal').find('.modal-dialog').removeClass('').addClass('modal-lg');
                    $('.modal').find('.modal-body').empty().append(response.data);

                })
                .catch(e => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo salisasao mal!',
                    });

                });

        }

        $(document).on('click', '.editEquipo', function(e) {
            // console.log($(this).attr('data-idcateg'));

            let idEquipo = $(this).attr('data-idEquipo');
            axios.post("{{ route('view-editar-equipo') }}", {
                    idEquipo: idEquipo,

                })
                .then(response => {

                    if (response.status == 200) {
                        $('#titleModal').empty().html('Editar Equipo');
                        $('.modal').modal('show');
                        $('.modal').find('.modal-dialog').removeClass('').addClass('modal-lg');
                        $('.modal').find('.modal-body').empty().append(response.data);

                    }
                })
                .catch(e => {

                    if (e.request.status == 422) {
                        var error = e.response;
                        console.log(error);
                        let errores = '';
                        error.data.data.forEach(function(v, i) {
                            // console.log(v);
                            errores += '<li>' + v + '</p>';
                        });
                        errores += '';

                        Swal.fire({
                            icon: 'error',
                            title: e.response.data.message,
                            html: '<ul class="text-left">' + errores + '</ul>',
                        });

                    } else if (e.response.data.message) {
                        resp = e.response.data.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: resp,
                        });
                    }

                });
        });
    </script>

@endsection
