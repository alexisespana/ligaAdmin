@extends('layouts.inicio')
@section('title', 'Equipos')
@section('css')
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker/flatpickr.min.css') }}">


@endsection

@section('content')
    <div class="card-header">
        <div class="card-body bg-body-tertiary">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @forelse ($categorias as $key=> $item)
                        <li class="nav-item">
                            <a class="nav-link {{ $key == 0 ? 'active ' : '' }}" id="{{ $item->id }}"
                                data-bs-toggle="tab" href="#tab-{{ $item->alias }}" role="tab"
                                aria-controls="tab-{{ $item->alias }}" aria-selected="true">{{ $item->nombre }}
                            </a>
                        </li>
                    @empty
                    @endforelse
                </ul>
                <div class="tab-content border border-top-0 p-3 " id="">

                    @forelse ($categorias as $key=>$item)
                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="tab-{{ $item->alias }}"
                            role="tabpanel" aria-labelledby="{{ $item->id }}">
                            <div class="row">
                                <div class="row justify-content-between">
                                    <div class="col-4">

                                        <button type="button" class="btn btn-primary mb-3 registrarJuegos"
                                            id="{{ $item->id }}">ENVIAR</button>
                                    </div>
                                    <div class="col-4">
                                        <div class="row alert alert-primary">
                                            <div class="col-md-6 col-sm-6 alert-heading fw-semi-bold jornada"
                                                id="{{ $item->jornadas[0]->nombre }}">
                                                {{ $item->jornadas[0]->nombre }}</div>
                                            <div class="col-md-6 col-sm-6 alert-heading fw-semi-bold">Fecha:
                                                {{ $item->jornadas[0]->fecha }}</div>

                                            {{-- <div class="alert alert-primary" role="alert">{{$item->jornadas[0]->nombre}} </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @forelse ($item->grupos as $key=> $grupo)
                                    @include('Content.Juegos.FormCrearJuegos.CategGrupos')
                                @empty

                                    categoria sin grupos
                                    @include('Content.Juegos.FormCrearJuegos.CategsinGrupos')
                                @endforelse
                            </div>
                        </div>

                    @empty
                    @endforelse


                </div>
            </div>
        </div>
    @stop
    @section('scripts')
        <script src="{{ asset('/js/datepicker/flatpickr.min.js') }}"></script>
        <script src="{{ asset('js/sweetAlert/sweetalert.min.js') }}"></script>

        <script>
            $(".registrarJuegos").on('click', function(e) {

                // let idCategoria = $(this).attr('id');

                // let idGrupo = $(this).parent().find('div.accordion')
                //     .map(function() {
                //         return $(this).attr("id");
                //     }).get();


                let juegos = $('div.juegoSeleccionado')
                    .map(function() {

                        let id_categoria = $(this).attr("id");
                        let equipo_local = $(this).find("div#equipo_local").children().attr("class");
                        let equipo_visitante = $(this).find("div#equipo_visitante").children().attr("class");
                        let arbitro = $(this).find("select#arbitro").val();
                        let sede = $(this).find("select#sede").val();
                        let hora = ($(this).find("input#hora").val() != '' ? $(this).find("input#hora").val() :
                            'null');

                        let var_vacia = 'null';


                        if (typeof equipo_local !== "undefined" || typeof equipo_visitante !== "undefined") {




                            return {
                                id_categoria: id_categoria,
                                equipo_local: equipo_local,
                                equipo_visitante: equipo_visitante,
                                arbitro: arbitro,
                                sede: sede,
                                hora: hora,
                            };
                        }

                    }).get();
                registrarJuegos(juegos);


            });

            const registrarJuegos = (juegos) => {

                axios.post("{{ route('registrar-juegos') }}", {
                        juegos: juegos,
                    })
                    .then(response => {
                        Swal.fire({
                            title: 'Registro Existoso.' ,
                            text: response.data.message,
                            icon: 'success',
                            // showCancelButton: true,
                            // showCancelButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                // location.reload();
                            }
                        })


                    })
                    .catch(e => {

                        if (e.request.status == 422) {
                            var error = e.response.data;
                            // console.log(error);

                            let errores = '<ul class="text-left">';
                            error.data.forEach(function(v, i) {


                                errores += '<li>' + v + '</li>';
                            });
                            errores += '</ul>';


                            Swal.fire({
                                title: error.message,
                                html: errores,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });


                        } else {


                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: e.response.config.data,
                            });
                        }

                    });
            }




            $(".equipos").on('click', function(e) {
                // $(this).addClass('disabled'); // PARA BLOUEAR ELBOTON DEL EQUIPO SELECCIONADO
                let idgrupo = $(this).parent().attr('id'); // EXTRAEMOS EL ID DEL GRUPO
                let idEquipoSeleccionado = $(this).attr('id'); // EXTRAEMOS EL ID DEL EQUIPO SELECCIONADO
                let juego = $('.juegos').find('div.bg-light');


                let divEquipo = $('.juegos').find('div#' + idgrupo).find('div.' + idEquipoSeleccionado).parent();
                let divequipo = divEquipo.attr('id');
                let n_juego = divEquipo.parent().attr('data');
                if ($('.juegos').find('div#' + idgrupo).find('div.' + idEquipoSeleccionado).length > 0) {


                    $('div.' + n_juego).find('div#' + divequipo).empty();

                };
                let div = 'equipo_local';


                if (juego.find('div.avatar').length > 0) {



                    juego.find('div.' + idEquipoSeleccionado).length == 1 ? $('div.' + n_juego).find('div#' + divequipo)
                        .empty() : '';

                    juego.find('div.avatar').parent().parent().attr('id') === div ? div = 'equipo_visitante' : div =
                        'equipo_local';


                }

                //SI EL DIV DEL EQUIO LOCAL YA ESTA SELECCIONADO COLOCAMOS EL EQUIPO EN EL DIV DE EQUIPO VISITANTE
                // if (juego.find('div.' + idEquipoSeleccionado).length > 0) {
                //     console.log(juego.find('div.' + idEquipoSeleccionado).parent().attr('id'));

                // }

                let equipoSeleccionado = $(this).children().clone();



                juego.find('div#' + div).empty().html(equipoSeleccionado);

                // console.log($('#grupo' + idgrupo).find('div#' + idEquipoSeleccionado).length);

                // if ($('#grupo' + idgrupo).find('div#' + idEquipoSeleccionado).length > 0) {

                //     $('#grupo' + idgrupo).find('div.' + div).attr('id', idEquipoSeleccionado).empty().html(
                //         equipoSeleccionado);

                // } else {
                //     $('#grupo' + idgrupo).find('div.' + div).attr('id', idEquipoSeleccionado).empty().html(
                //         equipoSeleccionado);

                // }
            });




            $(".juegoSeleccionado").on('click', function(e) {

                $('.card').find('div.bg-light').removeClass('bg-light');
                $('button.equipos').attr('disabled',
                    true); // SE BLOQUEAN TODOS LOS EQUIPOS PARA QUE SOLO SELECCIONE LOS DE SU GRUPO
                $('div#grupo_' + $(this).attr('id')).find('button.equipos').attr('disabled',
                    false); //  SOLO SE ACTIVAN LOS EQUIPOS DE SU GRUPO



                $(this).addClass('bg-light');
                $(this).find('select').attr('disabled', false);
                $(this).find('input#hora').attr('readonly', false);

            });

            $('.card').find('input#hora').each(function() {
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: 'H:i',
                    disableMobile: true

                });
            });
        </script>
    @endsection
