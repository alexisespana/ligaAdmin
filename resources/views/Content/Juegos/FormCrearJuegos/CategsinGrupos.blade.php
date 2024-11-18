<div class="row">
    @forelse ($item->grupo_categoria as $equiGrup)
        <div class="col-md-9 juegos">

            @for ($i = 1; $i <= count($equiGrup->equipos) / 2; $i++)

            {{$i}}
            @endfor

        </div>
        <div class="col-md-3">

            @foreach ($equiGrup->equipos as $equipos)
                <div class="col" id="grupo_{{ $equiGrup->grupo_id }}">
                    <button type="button" id="{{ $equipos->equipos->id }}"
                        class=" w-100 btn btn-light text-left p-1 equipos mb-2">
                        <div class="{{ $equipos->equipos->id }}">
                            <div class="avatar avatar-l">
                                <img class="rounded-circle"
                                    src="{{ asset('img/Escudo/') }}{{ $equipos->equipos->escudo }}" alt="" />
                            </div>
                        </div>
                        <div>

                            {{ $equipos->equipos->nombre }}
                        </div>
                    </button>
                </div>
            @endforeach
        </div>

    @empty
        <span class="">EL GRUPO NO
            TIENE
            EQUIPOS
            ASIGNADOS.</span class="">
    @endforelse
</div>
