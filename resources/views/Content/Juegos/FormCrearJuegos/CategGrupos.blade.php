<div class="accordion" id="{{ $grupo->id }}">

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#juegoOpen-grupo{{ $grupo->id }}" aria-expanded="true"
                aria-controls="juegoOpen-grupo{{ $grupo->id }}">
                {{ $grupo->nombre }}
            </button>
        </h2>
        <div id="juegoOpen-grupo{{ $grupo->id }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }} ">
            <div class="accordion-body">
                <div class="col-12 mb-4" id="grupo{{ $grupo->id }}">
                    <div class="card border h-100 border-primary">
                        <div class="card-body">

                            @forelse ($item->grupo_categoria as $grupCatg)
                                <div class="row">

                                    @if ($grupo->id == $grupCatg->grupo_id)
                                        <div class="col-md-9 juegos">

                                            @for ($i = 1; $i <= count($grupCatg->equipos) / 2; $i++)
                                                <div class="row juegoSeleccionado juego_{{ $i }} pb-5"
                                                    id="{{ $grupCatg->id }}" data="juego_{{ $i }}">

                                                    <div class="col-md-2 pt-4 text-end" id="equipo_local">
                                                        EQUIPO LOCAL
                                                    </div>
                                                    <div class=" pt-4 col-md-1 text-center">
                                                        VS
                                                    </div>
                                                    <div class="col-md-2 pt-3 text-start" id="equipo_visitante">
                                                        EQUIPO VISITANTE
                                                    </div>
                                                    <div class="col-md-3 arbitro text-start">
                                                        <label class="form-label" for="arbitro">Arbitro:</label>
                                                        <select class="form-select" disabled id="arbitro"
                                                            aria-label="Default select example" id="arbitro">
                                                            <option value="0">Seleccione</option>
                                                            @foreach ($arbitros as $arb)
                                                                <option value="{{ $arb->id }}">
                                                                    {{ $arb->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-2 sede text-start">
                                                        <label class="form-label" for="sede">Sede:</label>
                                                        <select class="form-select" disabled id="sede"
                                                            aria-label="Default select example" id="sede">
                                                            <option value="0">Seleccione</option>
                                                            @foreach ($sedes as $sed)
                                                                <option value="{{ $sed->id }}">
                                                                    {{ $sed->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label for="" class="form-label">Hora:</label>
                                                        <input class="form-control" placeholder="hora del partido"
                                                            id="hora" />


                                                    </div>
                                                </div>
                                            @endfor

                                        </div>
                                        <div class="col-md-3">

                                            <div class="row">
                                                @forelse ($grupCatg->equipos as $equiGrup)
                                                    <div class="col" id="grupo_{{ $grupCatg->id }}">
                                                        <button type="button" disabled
                                                            id="{{ $equiGrup->equipos->id }}"
                                                            class=" w-100 btn btn-light text-left p-1 equipos mb-2">
                                                            <div class="{{ $equiGrup->equipos->id }}">
                                                                <div class="avatar avatar-l">
                                                                    <img class="rounded-circle"
                                                                        src="{{ asset('img/Escudo/') }}{{ $equiGrup->equipos->escudo }}"
                                                                        alt="" />
                                                                </div>
                                                            </div>
                                                            <div>

                                                                {{ $equiGrup->equipos->nombre }}
                                                            </div>
                                                        </button>
                                                    </div>
                                                @empty
                                                    <span class="">EL GRUPO NO
                                                        TIENE
                                                        EQUIPOS
                                                        ASIGNADOS.</span class="">
                                                @endforelse
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            @empty
                                <li>LA CATEGORIA NO TIENE EQUPOS ASIGNADOS</li>
                            @endforelse

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
