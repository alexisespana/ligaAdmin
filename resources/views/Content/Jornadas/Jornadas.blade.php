@extends('layouts.inicio')
@section('title', 'Equipos')
@section('css')

    <link rel="stylesheet" href="{{ asset('css/dataTables/dataTables.bootstrap.min.css') }}" type="text/css">
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker/flatpickr.min.css') }}">



@endsection

@section('content')

    <div class="card-header">
        <h5>Jornadas</h5>
    </div>
    <div class="card-body">

        <div class="row">

            <div class="col-2">
                <div class="list-group" id="myList" role="tablist">
                    @forelse ($jornadas as $key=> $categ)
                        <a class="list-group-item list-group-item-action {{ $key == 0 ? 'active' : '' }}"
                            id="list-{{ $categ->alias }}-list" data-toggle="list" href="#list-{{ $categ->alias }}"
                            role="tab" aria-controls="{{ $categ->alias }}">
                            {{ $categ->nombre }}
                        </a>

                    @empty
                    @endforelse
                </div>
            </div>
            <div class="col-10">
                <div class="tab-content" id="nav-tabContent">
                    @forelse ($jornadas as $key=> $categ)
                        <div class="tab-pane fade  {{ $key == 0 ? ' show active' : '' }}" id="list-{{ $categ->alias }}"
                            role="tabpanel" aria-labelledby="list-{{ $categ->alias }}-list">
                            <div class="row">

                                @if ($categ->cant_grupos > 0)
                                    @forelse ($categ->grupos as $catg)
                                        <div class="col-sm-6">

                                            <div class="card border-primary mb-3 ">
                                                {{-- NOMBRE DEL GRUPO   --}}
                                                <h5 class="text-center pt-2">{{ $catg->nombre }}</h5>
                                                <hr>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        @forelse ($categ->jornadas as $jorn)
                                                            <a class=" btn btn-info list-group-item list-group-item-action modificarJornada"
                                                                aria-current="true" id="{{ $jorn->id }}">
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <h5 class="mb-1">{{ $jorn->nombre }}</h5>
                                                                    <span
                                                                        class=" {{ $jorn->status == 0 ? 'text-success' : ($jorn->status == 1 ? 'text-info' : ($jorn->status == 2 ? 'text-secondary' : 'text-danger')) }}">
                                                                        status:
                                                                        {{ $jorn->status == 0 ? 'Completado' : ($jorn->status == 1 ? 'vigente' : ($jorn->status == 2 ? 'Pendiente' : 'Suspendido')) }}
                                                                        <i
                                                                            class=" {{ $jorn->status == 0 ? 'fas fa-check-double' : ($jorn->status == 1 ? 'fas fa-check' : ($jorn->status == 2 ? 'fas fa-minus-circle' : 'far fa-times-circle')) }}">
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                                <small class="mb-1"> Fecha:
                                                                    {{ (is_null($jorn->fecha)) ? $jorn->fecha : 'sin fecha definida ' }}
                                                                </small>
                                                                {{-- <small>And some small print.</small> --}}
                                                            </a>
                                                        @empty
                                                            EL GRUPO DE LA CATEGORIA NO TIENE JORNADAS ASIGNADAS
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse

                                    {{-- SI LA CATEGORIA NO TIENE GRUPO --}}
                                @else
                                    <div class="card border-primary mb-3 ">

                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                @forelse ($categ->jornadas as $jorn)
                                                    <a class=" btn btn-info list-group-item list-group-item-action modificarJornada"
                                                        aria-current="true" id="{{ $jorn->id }}">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1">{{ $jorn->nombre }}</h5>
                                                            <span
                                                                class=" {{ $jorn->status == 0 ? 'text-success' : ($jorn->status == 1 ? 'text-info' : ($jorn->status == 2 ? 'text-secondary' : 'text-danger')) }}">
                                                                status:
                                                                {{ $jorn->status == 0 ? 'Completado' : ($jorn->status == 1 ? 'vigente' : ($jorn->status == 2 ? 'Pendiente' : 'Suspendido')) }}
                                                                <i
                                                                    class=" {{ $jorn->status == 0 ? 'fas fa-check-double' : ($jorn->status == 1 ? 'fas fa-check' : ($jorn->status == 2 ? 'fas fa-minus-circle' : 'far fa-times-circle')) }}">
                                                                </i>
                                                            </span>
                                                        </div>
                                                        <small class="mb-1"> Fecha:
                                                            {{ isset($jorn->fecha) ? $jorn->fecha : 'sin fecha definida ' }}
                                                        </small>
                                                        {{-- <small>And some small print.</small> --}}
                                                    </a>

                                                @empty
                                                    EL GRUPO DE LA CATEGORIA NO TIENE JORNADAS ASIGNADAS
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>



                        </div>
                    @empty
                    @endforelse

                </div>
            </div>


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
    <script src="{{ asset('/js/datepicker/flatpickr.min.js') }}"></script>


    <script>
        //   dataTableCategorias(true);
        $('#myList a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })



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

        $(document).on('click', '.modificarJornada', function(e) {
            // console.log($(this).attr('data-idcateg'));

            // let idCategoria = $(this).attr('id');
            let idJornada = $(this).attr('id');
            //alert(idCategoria); //
            axios.post("{{ route('view-crear-jornada') }}", {
                    idJornada: idJornada,

                })
                .then(response => {

                    if (response.status == 200) {
                        $('#titleModal').empty().html('Agregar Jornada');
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
