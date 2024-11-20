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

                        <ul class="list-group list-group-flush list-group-numbered">
                            <div class="row">
                                @forelse ($item->grupo_categoria as $grupCatg)
                                    <div class="col mb-4">
                                        <div class="card border h-100 border-primary">
                                            <div class="card-body">
                                                <div class="card-title"> {{ $grupCatg->grupos->nombre }}</div>

                                                    <table class="table table-hover table-striped overflow-hidden">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col">Phone</th>
                                                                <th scope="col">Address</th>
                                                                <th scope="col">Status</th>
                                                                <th class="text-end" scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           <tr></tr>
                                                            {{-- @forelse ($categorias->posiciones as $posicion)
                                                            <tr>
                                                                @if (
                                                                    $posicion->idgrupo_categoria->categoria_id == $grupCatg->categoria_id &&
                                                                        $posicion->idgrupo_categoria->grupo_id == $grupCatg->grupo_id)
                                                                    <td class="text-nowrap">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar avatar-xl">
                                                                                <img class="rounded-circle"
                                                                                    src="{{ asset('img/Escudo/') }}{{ $posicion->equipos->escudo }}"
                                                                                    alt="" />
                                                                            </div>
                                                                            <div class="ms-2">
                                                                                {{ $posicion->equipos->nombre }}</div>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @empty
                                                            <span class="">EL GRUPO NO TIENE EQUIPOS
                                                                ASIGNADOS.</span class="">
                                                        @endforelse --}}


                                                       

                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <span class="">LA CATEGORIA NO TIENE GRUPOS ASIGNADOS.</span class="">
                                @endforelse

                            </div>

                        </ul>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    @stop
    @section('scripts')
    @endsection
