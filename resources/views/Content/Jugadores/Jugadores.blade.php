@extends('layouts.inicio')
@section('title', 'Jugadores')
@section('css')

    <link rel="stylesheet" href="{{ asset('css/dataTables/dataTables.bootstrap.min.css') }}" type="text/css">
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">

    <!-- Latest compiled and minified JavaScript -->


@endsection

@section('content')
    <div class="card-header">
        Lista de Jugadores
        <div class="row">
            <div class="form-group pt-3">
                <label for="multiple-select">Equipos</label>
                {{-- <select class="selectpicker" name="equipos[]" id="equipos" data-live-search="true" multiple
                    data-actions-box="true" show-tick data-width="100%">
                    @foreach ($categorias as $categ)
                        <option data-subtext="{{ $categ->nombre }}" value="{{ $categ->id }}">
                            {{ $categ->nombre }}
                        </option>
                    @endforeach
                </select> --}}

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive scrollbar">
            <table id="jugadores" class="table table-bordered table-striped fs-10 mb-0">
                <thead class="bg-200">
                    <tr>
                        <th class="text-900 sort" data-sort="Nombre">#</th>
                        <th class="text-900 sort" data-sort="Nombre">Nombre</th>
                        <th class="text-900 sort" data-sort="NomnbreCorto">Cedula</th>
                        <th class="text-900 sort" data-sort="grupos">Posicion</th>
                        <th class="text-900 sort" data-sort="n_grupos">Fecha Nac.</th>
                        <th class="text-900 sort" data-sort="cantEquipos">Teléfono</th>
                        <th class="text-900 sort" data-sort="cantEquipos">Dirección</th>
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

    <script src="{{ asset('js/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.selectpicker').select2();
            dataTableJugadores(true);


        });

        function dataTableJugadores(params) {
            var token = $("input[name=_token]").val();


            $('#jugadores').DataTable({
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
                    text: 'Ingresar Jugadores',
                    attr: {
                        'title': 'Ingresar Jugadores',
                        'class': 'btn btn-falcon-success btn-sm',

                    },
                    action: function() {
                        AgregarCategoria();
                    }
                }],

                select: true,
                paging: true,
                ajax: {
                    "url": "{{ route('datatables-jugadores') }}",
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
                        data: 'CEDULA',
                        name: 'CEDULA',
                    },
                    {
                        data: 'POSICION',
                        name: 'POSICION',
                        visible: false,
                    },
                    {
                        data: 'FECHA_NACIMIENTO',
                        name: 'FECHA_NACIMIENTO',
                    },
                    {
                        data: 'TELEFONO',
                        name: 'TELEFONO',
                    },
                    {
                        data: 'DIRECCION',
                        name: 'DIRECCION',
                    },
                    {
                        data: 'BUTTONS',
                        name: 'BUTTONS',
                        visible: true,
                    },


                ]
            });
        }
    </script>
@endsection
