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

    @if (session('success'))
        <div class="d-flex">
            <div class="toast show align-items-center text-white bg-success border-0" role="alert"
                data-bs-autohide="false" aria-live="assertive" aria-atomic="true">
                <div class="d-flex flex-between-center">
                    <div class="toast-body text-bg-success">
                        {{ session('success') }}
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close me-2 m-auto" type="button" data-bs-dismiss="toast"
                            aria-label="Close"></button></div>
                </div>
            </div>
        </div>
    @elseif (session('error'))
        <div class="d-flex">
            <div class="toast show align-items-center text-white bg-danger border-0" role="alert" data-bs-autohide="false"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex flex-between-center">
                    <div class="toast-body text-bg-danger">
                        {{ session('error') }}
                    </div>
                    <div data-bs-theme="dark"><button class="btn-close me-2 m-auto" type="button" data-bs-dismiss="toast"
                            aria-label="Close"></button></div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Lista de categorias


        </div>
        <div class="table-responsive scrollbar">
            <table id="categorias" class="table table-bordered table-striped fs-10 mb-0">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 sort" data-sort="Nombre">#</th>
                        <th class="text-900 sort" data-sort="Nombre">Nombre</th>
                        <th class="text-900 sort" data-sort="NomnbreCorto">Nomnbre Corto</th>
                        <th class="text-900 sort" data-sort="cantEquipos">Cantidad Equipos</th>
                        <th class="text-900 sort" data-sort="cantEquipos">Equipos</th>
                        <th class="text-900 sort" data-sort="cantEquipos">Opciones</th>
                    </tr>
                </thead>

                <tbody class="list">

                </tbody>
            </table>

        </div>

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
        $('.selectpicker').selectpicker();

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
                    text: 'Crear Categoria',
                    attr: {
                        'title': 'Crear Categoria',
                        'class': 'btn btn-falcon-success btn-sm',

                    },
                    action: function() {
                        AgregarCategoria();
                    }
                }],

                select: true,
                paging: true,
                ajax: {
                    "url": "{{ route('datatables-categorias') }}",
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
                        class: 'nombre'
                    },
                    {
                        data: 'ALIAS',
                        name: 'ALIAS',
                    },
                    {
                        data: 'CANTIDAD_EQUIPOS',
                        name: 'CANTIDAD_EQUIPOS',
                    },
                    {
                        data: 'EQUIPOS',
                        name: 'EQUIPOS',
                    },
                    {
                        data: 'BUTTONS',
                        name: 'BUTTONS',
                        visible: true,
                    },


                ]
            });
        }

        const AgregarCategoria = () => {
            $('#titleModal').empty().html('Agregar Nueva Categoría');
            axios.get("{{ route('view-agregar-categorias') }}")
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

        $(document).on('click', '.editCateg', function(e) {
            // console.log($(this).attr('data-idcateg'));

            let idCateg = $(this).attr('data-idcateg');
            axios.post("{{ route('view-editar-categoria') }}", {
                    idCateg: idCateg,

                })
                .then(response => {

                    if (response.status == 200) {
                        $('#titleModal').empty().html('Editar Categoría');
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

        $(document).on('click', '.deleteCateg', function(e) {
            let nombre= $(this).parent().parent().parent().find('td.nombre').text();

            let idCateg = $(this).attr('data-idcateg');
            Swal.fire({
                title: '¿Desea eliminar esta Categoría?',
                text: nombre,
                showDenyButton: true,
                confirmButtonText: 'Si',
                denyButtonText: 'Cancelar',
            }).then((result) => {

                if (result.isConfirmed) {
                    axios.post("{{ route('eliminar-categorias') }}", {
                            idCateg: idCateg
                        })
                        .then(response => {
                            let data = response;

                            if (data.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Exito',
                                    text: response.data.message,
                                });
                                dataTableCategorias(true);

                            }

                        })
                        .catch(e => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salio mal!',
                            });
                        });

                } else if (result.isDenied) {
                    // Nothing
                }
            })
        });
    </script>

@endsection
