@extends('layouts.inicio')
@section('title', 'Grupos')
@section('css')
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}">

    <!-- Latest compiled and minified JavaScript -->


@endsection

@section('content')

    <div class="card-header">
        Lista de Grupos
    </div>
    <div class="card-body bg-body-tertiary">
        <div class="col-md-6">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @forelse ($categorias as $key=> $item)
                    <li class="nav-item">
                        <a class="nav-link {{ $key == 0 ? 'active ' : '' }}" id="{{ $item->id }}" data-bs-toggle="tab"
                            href="#tab-{{ $item->alias }}" role="tab" aria-controls="tab-{{ $item->alias }}"
                            aria-selected="true">{{ $item->nombre }}
                        </a>
                    </li>


                @empty
                @endforelse


            </ul>
            <div class="tab-content border border-top-0 p-3 " id="">

                @forelse ($categorias as $key=>$item)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="tab-{{ $item->alias }}"
                        role="tabpanel" aria-labelledby="{{ $item->id }}">

                        {{-- <div class="card-title">{{is_array($item->grupos) ? $item->grupos[0]->nombre:''}} </div> --}}

                        <ul class="list-group list-group-flush list-group-numbered">
                            {{-- @if (is_array($item->grupos)) --}}
                            <div class="row">
                                @forelse ($item->grupos as $grupo)
                                    <div class="col mb-4">
                                        <div class="card border h-100 border-primary">
                                            <div class="card-body">
                                                <div class="card-title"> {{ $grupo->nombre }}</div>
                                                @forelse ($item->grupo_categoria as $grupCatg)
                                                    @if ($grupo->id == $grupCatg->grupo_id)
                                                        @forelse ($grupCatg->equipos as $equiGrup)
                                                            <li class="list-group-item">
                                                                <div class="avatar avatar-l mx-2">
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset("img/Escudo/") }}{{ $equiGrup->equipos->escudo }}"
                                                                        alt="" />
                                                                </div>
                                                                {{ $equiGrup->equipos->nombre }}
                                                            </li>

                                                        @empty
                                                            <span class="">EL GRUPO NO TIENE EQUIPOS
                                                                ASIGNADOS.</span class="">
                                                        @endforelse
                                                    @endif


                                                @empty
                                                    <li>LA CATEGORIA NO TIENE EQUPOS ASIGNADOS</li>
                                                @endforelse

                                            </div>
                                        </div>

                                    </div>

                                @empty
                                    {{-- EN CASO DE QUE LA CATEGORIA NO TENGA GRUPOS SE MUESTRAN TODOS LOS EQUIPOS --}}
                                    @forelse ($item->grupo_categoria[0]->equipos as $equipos)
                                        <li class="list-group-item">
                                            <div class="avatar avatar-l mx-2">
                                                <img class="rounded-circle" src="{{ asset("img/Escudo/") }}{{ $equipos->equipos->escudo }}"
                                                    alt="" />
                                            </div>
                                            {{ $equipos->equipos->nombre }}
                                        </li>
                                    @empty
                                        <li>NO HAY EQUIPOS EN LA CATEGORIA {{ $categ->nombre }} </li>
                                    @endforelse
                                @endforelse
                                @if ($item->cant_grupos > 0)
                                    <button class="btn btn-outline-primary m-1 mb-1 defGrupo" type="button">
                                        <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>
                                    </button>
                                @endif
                            </div>
                            {{-- @else
                                <div class="row">
                                    <div class="col mb-4">
                                        <div class="card border h-100 border-primary">
                                            <div class="card-body">
                                                <div class="card-title"> </div>
                                                @forelse ($item->equipos as $equipo)
                                                    <li class="list-group-item">
                                                        <div class="avatar avatar-l mx-2">
                                                            <img class="rounded-circle" src="{{ $equipo->escudo }}"
                                                                alt="" />
                                                        </div>
                                                        {{ $equipo->nombre }}
                                                    </li>


                                                @empty
                                                    <li>LA CATEGORIA NO TIENE EQUPOS ASIGNADOS</li>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}


                        </ul>
                    </div>

                    @empty



                        <li>NO TIENE CATEGORIAS ASIGNADOS</li>
                    @endforelse

                </div>





            </div>
        </div>

        </div>
    @stop
    @section('scripts')
        <script src="{{ asset('/js/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('js/sweetAlert/sweetalert.min.js') }}"></script>

        <script src="{{ asset('js/bootstrap-select/bootstrap-select.min.js') }}"></script>

        <script>
            $(document).on('click', '.defGrupo', function(e) {
                // console.log($(this).attr('data-idcateg'));
                e.preventDefault();
                let idCateg = $('.nav-tabs').find('a.active').attr('id');
                let nombGrupo = $('.nav-tabs').find('a.active').text();
                axios.post("{{ route('view-agregar-grupos') }}", {
                        idCateg: idCateg,

                    })
                    .then(response => {
                        if (response.status == 200) {
                            $('#titleModal').empty().html('Asignar Equipos a la Categoría ' + nombGrupo);
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
