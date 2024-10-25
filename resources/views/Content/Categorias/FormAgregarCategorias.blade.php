<div class="container-fluid">

    <input class="form-control" id="idCategoria" name="idCategoria" type="hidden" value="{!! isset($categoria) ? $categoria[0]->id : '' !!}">
    <div class="row g-3">
        <div class="form-floating col">
            <input class="form-control" id="nombre" name="nombre" type="text" placeholder=""
                value="{!! isset($categoria) ? $categoria[0]->nombre : '' !!}">
            <label for="nombre">Nombre de la Categoría</label>
        </div>
    </div>
    <div class="row g-3 pt-2">
        <div class="form-floating">
            <input class="form-control" id="alias" name="alias" type="text" placeholder=""
                value="{!! isset($categoria) ? $categoria[0]->alias : '' !!}">
            <label for="alias">Alías de la Categoría</label>
        </div>
    </div>

    <div class="form-group pt-3">
        <label for="multiple-select">Equipos</label>
        <select class="selectpicker" name="equipos[]" id="equipos" data-live-search="true" multiple
            data-actions-box="true" show-tick data-width="100%">
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
    <div class="row g-3 py-5">

        <div class="col">

            <div class="form-check form-switch col-md-12 pt-0">
                <input class="form-check-input grupos" type="checkbox" role="switch" id="grupos" name="grupo"
                    value="false">
                <label class="form-check-label" for="grupos">¿Grupo en la categoría?</label>
            </div>
            <div class="form-floating col">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex justify-content-end justify-content-md-center order-1 order-md-0">
                        <div>
                            <div class="input-group input-group-sm flex-nowrap" data-quantity="data-quantity">
                                <span
                                    class="btn btn-sm btn-outline-secondary border-300 disabled px-2 quantity-left-minus"
                                    data-type="minus">-
                                </span>

                                <input class="form-control text-center px-2 input-spin-none" type="number"
                                    name="n_grupo" id="n_grupo" value="0" disabled style="width: 50px" />
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
        <div class="col">
            <div class="form-check form-switch col-md-12 pt-0">
                <input class="form-check-input idavuelta" type="checkbox" role="switch" id="idavuelta" name="idavuelta"
                    value="false">
                <label class="form-check-label" for="idavuelta">¿Los partidos serán ida y vuelta?</label>
            </div>
        </div>
    </div>
    <div class="col-12"><button class="btn btn-primary {!! isset($categoria) ? 'editar-categorias' : 'agregar-categorias' !!}" type="button">Enviar</button></div>
</div>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

       

        $(document).on('click', '.agregar-categorias', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Desea crear la Categoría?",
                showCancelButton: true,
                confirmButtonText: "Si",
                cancelButtonText: 'No',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {


                    let idCategoria = $('#idCategoria').val();
                    let nombre = $('#nombre').val();
                    let alias = $('#alias').val();
                    let grupos = $('#grupos').val();
                    let n_grupo = $('#n_grupo').val();
                    let equipos = $('#equipos').val();
                    let idavuelta = $('#idavuelta').val();
                    axios.post("{{ route('agregar-categorias') }}", {
                            idCategoria: idCategoria,
                            nombre: nombre,
                            alias: alias,
                            grupos: grupos,
                            n_grupo: n_grupo,
                            equipos: equipos,
                            idavuelta: idavuelta,

                        })
                        .then(response => {


                            if (response.data.status == 200) {
                                $('.modal').modal('hide');
                                Swal.fire({
                                    title: "Categoría Creada!",
                                    text: response.data.message,
                                    icon: "success",
                                    confirmButtonText: "OK",


                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        location.reload();


                                    }
                                });
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
                                    html: '<ul class="text-left">' + errores +
                                        '</ul>',
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
                } else if (result.isDenied) {

                }
            });


        });

        $("#idavuelta").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', 'true');
            } else {
                $(this).attr('value', 'false');
            }
        });

        $("#grupos").on('change', function() {
            if ($(this).is(':checked')) {
                $(this).attr('value', 'true');
                $('#n_grupo').val(2).removeAttr('disabled');
                $('.quantity-right-plus').removeClass('disabled');
                $('.quantity-left-minus').removeClass('disabled');
            } else {
                $(this).attr('value', 'false');
                $('#n_grupo').val('0').attr('disabled', true);
                $('.quantity-right-plus').addClass('disabled');
                $('.quantity-left-minus').addClass('disabled');

            }
        });

        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#n_grupo').val());

            // If is not undefined
            let max = parseInt("6");
            // Increment

            if (quantity < max) {
                $('#n_grupo').val(quantity + 1);
            }


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#n_grupo').val());

            // If is not undefined
            let min = parseInt("2");
            // Increment
            if (quantity > min) {
                $('#n_grupo').val(quantity - 1);
            }
        });

    });
</script>
