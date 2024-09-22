<script src="{{ asset('/js/jscolor/jscolor.min.js') }}"></script>
<div class="container-fluid">
    <form class="row g-3" method="post" action="{!! isset($equipo) ? route('editar-equipo') : route('agregar-equipo') !!}">
        @csrf
        <input class="form-control" id="idEquipo" name="idEquipo" type="hidden" value="{!! isset($equipo) ? $equipo[0]->id : '' !!}">

        <div class="row g-3">

            <div class="form-floating col-md-6">
                <input class="form-control" id="nombre" name="nombre" type="text" value="{!! isset($equipo) ? $equipo[0]->nombre : '' !!}"
                    placeholder="">
                <label for="nombre">Nombre del Equipo</label>
            </div>
            <div class="form-floating col-md-6">
                <input class="form-control" id="alias" name="alias" type="text" value="{!! isset($equipo) ? $equipo[0]->abr : '' !!}"
                    placeholder="">
                <label for="alias">Alías del Equipo</label>
            </div>
        </div>
        <div class="row g-3">

            <div class="form-floating col-md-6">

                <input class="form-control" data-jscolor="{}" id="color2" name="color1" type="text"
                    value="{!! isset($equipo) ? $equipo[0]->color : '' !!}" placeholder="">
                <label for="color">color 1</label>
            </div>
            <div class="form-floating col-md-6">

                <input class="form-control" data-jscolor="{}" id="color2" name="color2" type="text"
                    value="{!! isset($equipo) ? $equipo[0]->color_text : '' !!}" placeholder="">
                <label for="color">color 2</label>
            </div>
        </div>

        <div class="row g-3">
            <div class="form-group col-md-6">
                <label for="multiple-select">Categorías</label>
                <select class="selectpicker" name="categorias[]" data-live-search="true" multiple
                    data-actions-box="true" show-tick data-width="100%">
                    @foreach ($categorias as $item)
                        @php
                            $selected = '';
                        @endphp
                        @if (isset($equipo[0]->categoria))
                            {{-- SI SE VA A EDITAR Y YA TIENE EQUIPOS SELECCIONADOS SE RECORREN --}}
                            @foreach ($equipo[0]->categoria as $equip)
                                @if ($equip->id === $item->id)
                                    @php
                                        $selected = 'selected';
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        <option {{ $selected }} data-subtext="{{ $item->alias }}" value="{{ $item->id }}">
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="row g-3">
            <div class="form-floating">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del Equipo"
                    style="height: 100px" >{!! isset($equipo) ? $equipo[0]->descripcion : '' !!}</textarea>
                <label for="descripcion" name="descripcion">Descripción del Equipo</label>
            </div>

        </div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Enviar</button></div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

    });
</script>
