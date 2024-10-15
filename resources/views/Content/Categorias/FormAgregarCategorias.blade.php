<div class="container-fluid">
    <form class="row g-3" method="post" action="{!! isset($categoria) ? route('editar-categorias') : route('agregar-categorias') !!}">
        @csrf
        <input class="form-control" id="idCategoria" name="idCategoria" type="hidden" value="{!! isset($categoria) ? $categoria[0]->id : '' !!}">
        <div class="row g-3">
            <div class="form-floating col">
                <input class="form-control" id="nombre" name="nombre" type="text" placeholder=""
                    value="{!! isset($categoria) ? $categoria[0]->nombre : '' !!}">
                <label for="nombre">Nombre de la Categoría</label>
            </div>
        </div>
        <div class="row g-3">
            <div class="form-floating">
                <input class="form-control" id="alias" name="alias" type="text" placeholder=""
                    value="{!! isset($categoria) ? $categoria[0]->alias : '' !!}">
                <label for="alias">Alías de la Categoría</label>
            </div>
        </div>
        <div class="row g-3">

            <div class="form-check form-switch col-md-4 pt-0">
                <input class="form-check-input grupos" type="checkbox" role="switch" id="grupos" name="grupo">
                <label class="form-check-label" for="grupos">¿Grupo en la categoría?</label>
            </div>
            <div class="form-floating col-2">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex justify-content-end justify-content-md-center order-1 order-md-0">
                        <div>
                            <div class="input-group input-group-sm flex-nowrap" data-quantity="data-quantity">
                                <span
                                    class="btn btn-sm btn-outline-secondary border-300 disabled px-2 quantity-left-minus"
                                    data-type="minus">-
                                </span>

                                <input class="form-control text-center px-2 input-spin-none" type="number" name="n_grupo"
                                    id="quantity" value="0" disabled
                                    aria-label="Amount (to the nearest dollar)" style="width: 50px" />
                                <span
                                    class="btn btn-sm btn-outline-secondary border-300 disabled px-2 quantity-right-plus"
                                    data-type="plus">+
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        $("#grupos").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', 'true');
                $('#quantity').val(2).removeAttr('disabled');
                $('.quantity-right-plus').removeClass('disabled');
                $('.quantity-left-minus').removeClass('disabled');
            } else {
                $(this).attr('value', 'false');
                $('#quantity').val('0').attr('disabled', true);
                $('.quantity-right-plus').addClass('disabled');
                $('.quantity-left-minus').addClass('disabled');

            }
        });

        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            
            // If is not undefined
            let max = parseInt("6");
            // Increment

            if (quantity < max) {
                $('#quantity').val(quantity + 1);
            }


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined
            let min = parseInt("2");
            // Increment
            if (quantity > min) {
                $('#quantity').val(quantity - 1);
            }
        });


    });
</script>
