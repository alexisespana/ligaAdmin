@extends('layouts.inicio')
@section('title', 'Equipos')
@section('css')
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">

    <!-- Latest compiled and minified JavaScript -->


@endsection

@section('content')
    <div class="card-header">

    </div>
    <div class="card-body">
        <div class="accordion">
            @foreach ($categorias as $key => $categ)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-{{ $categ->alias }}" aria-expanded="true"
                            aria-controls="panelsStayOpen-{{ $categ->alias }}">
                            {{ $categ->nombre }}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-{{ $categ->alias }}"
                        class="accordion-collapse collapse {{ $key == 0 ? 'show ' : '' }} ">
                        <div class="accordion-body">
                            <div class="row">
                                @forelse ($categ->grupos as $grupo)
                                    {{-- ACA VAN LOS GRUPOS DE LAS CATEGORIAS --}}
                                    <div class="col-6 mb-4">
                                        <div class="card border h-100 border-primary">
                                            <div class="card-body">
                                                <div class="card-title"> {{ $grupo->nombre }}</div>
                                                @foreach ($juegos as $jue => $jueg)
                                                    @if ($jueg->id_categoria == $categ->id)
                                                        <div class="list-group">
                                                            <h6>
                                                                <a href="#"
                                                                    class="list-group-item list-group-item-action mt-1">
                                                                    <div class="row">
                                                                        <div class="col-1 text-end">
                                                                            <div class="avatar avatar-l ">
                                                                                <img class="rounded-circle"
                                                                                    src="{{asset('img/Escudo'. $jueg->equipo_local->escudo) }}"
                                                                                    alt="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 text-start mt-2">
                                                                            {{ $jueg->equipo_local->nombre }}

                                                                        </div>
                                                                        <div class="col-md-2 text-center">

                                                                                <label>{{ $jueg->hora }}</label>
                                                                                <label>{{ $jueg->fecha }}</label>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="avatar avatar-l ">
                                                                                <img class="rounded-circle"
                                                                                     src="{{asset('img/Escudo'. $jueg->equipo_visitante->escudo) }}"
                                                                                    alt="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-2">
                                                                            {{ $jueg->equipo_visitante->nombre }}
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            {{ $jueg->sede->nombre }}
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </h6>

                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>


                                @empty
                                    {{-- EN CASO DE QUE LA CATEGORIA NO TENGA GRUPOS SE MUESTRAN TODOS LOS EQUIPOS --}}
                                    @forelse ($categ->grupo_categoria[0]->equipos as $equipos)
                                        <li>{{ $equipos->equipos->nombre }}</li>
                                    @empty
                                        <li>NO HAY EQUIPOS EN LA CATEGORIA {{ $categ->nombre }} </li>
                                    @endforelse
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@stop
@section('scripts')
@endsection
