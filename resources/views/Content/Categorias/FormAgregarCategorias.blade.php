<div class="container-fluid">
    <form class="row g-3" method="post" action="{!! isset($categoria) ? route('editar-categorias') : route('agregar-categorias') !!}">
        @csrf
        <input class="form-control" id="idCategoria" name="idCategoria" type="hidden" value="{!! isset($categoria) ? $categoria[0]->id : '' !!}">

        <div class="form-floating mb-3">
            <input class="form-control" id="nombre" name="nombre" type="text" value="{!! isset($categoria) ? $categoria[0]->nombre : '' !!}">
            <label for="nombre">Nombre de la Categoría</label>
        </div>
        <div class="form-floating">
            <input class="form-control" id="alias" name="alias" type="text" value="{!! isset($categoria) ? $categoria[0]->alias : '' !!}">
            <label for="alias">Alías de la Categoría</label>
        </div>

        <div class="form-group">
            <label for="multiple-select">Equipos</label>
            <select class="selectpicker" name="equipos[]" data-live-search="true" multiple data-actions-box="true"
                show-tick data-width="100%">
                @foreach ($equipos as $item)
                    @php
                        $selected = '';
                    @endphp
                    @if (isset($categoria[0]->equipos))
                        {{-- SI SE VA A EDITAR Y YA TIENE EQUIPOS SELECCIONADOS SE RECORREN --}}
                        @foreach ($categoria[0]->equipos as $categ)
                            @if ($categ->id === $item->id)
                                @php
                                    $selected = 'selected';
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    <option {{ $selected }} data-subtext="{{ $item->abr }}" value="{{ $item->id }}">
                        {{ $item->nombre }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Enviar</button></div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

    });
</script>
