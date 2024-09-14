@extends('layouts.inicio')
@section('title', 'Equipos')
@section('css')

@endsection

@section('content')

    <div class="row mb-3">
        @foreach ($categorias as $categ)
            <div class="col-xl-6 pe-xl-2 my-2">
                <div class="card mb-3 h-lg-100">
                    <div class="card-header">
                        <div class="row flex-between-end">
                            <div class="col-auto align-self-center">

                                {{ $categ->nombre }}
                            </div>

                        </div>
                        <div class="card-body bg-body-tertiary">
                            <div class="tab-content">

                                

                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th class="text-end" scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($equipos as $key => $equipo)
                                                @foreach ($equipo->categoria as $catg)
                                                    @if ($catg->id === $categ->id)
                                                        <tr>
                                                            <td>{{ $key }} </td>
                                                            <td>{{ $equipo->nombre }} </td>


                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    @stop
    @section('scripts')

    @endsection
