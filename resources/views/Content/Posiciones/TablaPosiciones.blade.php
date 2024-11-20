@extends('layouts.inicio')
@section('title', 'Tabla de Posiciones')
@section('css')
    <link href="{{ asset('/css/toastr/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sweetAlert/sweetalert.css') }}">

    <!-- Latest compiled and minified JavaScript -->


@endsection

@section('content')
    <div class="card-header">
        Tabla Posiciones
    </div>

    <div class="card-body bg-body-tertiary">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @forelse ($categorias->categorias as $key=> $item)
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


                @forelse ($categorias->categorias as $key=>$item)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="tab-{{ $item->alias }}"
                        role="tabpanel" aria-labelledby="{{ $item->id }}">

                        <div class="row g-3 mb-3">
                            @forelse ($item->grupo_categoria as $grupCatg)
                                <div class="col-lg-6">
                                    <div class="card border h-100 border-primary">
                                        <div class="card-body">
                                            <div class="card-title"> {{ $grupCatg->grupos->nombre }}</div>
                                            <div class="table-responsive scrollbar">

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td scope="col">Pos</td>
                                                            <td scope="col">Club</td>
                                                            <td scope="col">PJ</td>
                                                            <td scope="col">G</td>
                                                            <td scope="col">E</td>
                                                            <td scope="col">P</td>
                                                            <td scope="col">GF</td>
                                                            <td scope="col">GC</td>
                                                            <td scope="col">DG</th>
                                                            <th scope="col">Pts</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($categorias->posiciones as $posicion)
                                                            <tr>
                                                                @if (
                                                                    $posicion->idgrupo_categoria->categoria_id == $grupCatg->categoria_id &&
                                                                        $posicion->idgrupo_categoria->grupo_id == $grupCatg->grupo_id)
                                                                    
                                                                    <td>{{ $posicion->posicion }}</td>
                                                                    <td class="text-nowrap" >
                                                                        <div class="d-flex align-items-center"data-bs-placement="top" title="{{ $posicion->equipos->nombre}}" style="cursor: pointer" >
                                                                            <div class="avatar avatar-xl">
                                                                                <img class="rounded-circle"
                                                                                    src="{{ asset('img/Escudo/') }}{{ $posicion->equipos->escudo }}"
                                                                                    alt="" />
                                                                            </div>
                                                                            <div class="ms-2" data-bs-toggle="tooltip" >
                                                                                {{ $posicion->equipos->abr }}</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $posicion->jugados }}</td>
                                                                    <td>{{ $posicion->ganados }}</td>
                                                                    <td>{{ $posicion->empate }}</td>
                                                                    <td>{{ $posicion->perdidos }}</td>
                                                                    <td>{{ $posicion->goles_favor }}</td>
                                                                    <td>{{ $posicion->goles_contra }}</td>
                                                                    <td>{{ $posicion->dif_goles }}</td>
                                                                    <th>{{ $posicion->puntos }}</th>

                                                                @endif
                                                            </tr>
                                                        @empty
                                                            <span class="">EL GRUPO NO TIENE EQUIPOS
                                                                ASIGNADOS.</span class="">
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <span class="">LA CATEGORIA NO TIENE GRUPOS ASIGNADOS.</span class="">
                            @endforelse

                        </div>

                    </div>
                @empty
                @endforelse

            </div>
        </div>
    @stop
    @section('scripts')
    @endsection
