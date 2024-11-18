<div class="row">
    @foreach ($categoria as $key => $categ)
        @foreach ($categ->grupos as $keygrup => $grupo)
            <div class="col grupo p-2" id="{{ $grupo->id }}">
                <div class="card border h-100 border-primary">
                    <div class="card-body">
                        <div class="card-title text-center"> {{ $grupo->nombre }} </div>
                        <ul class="list-group">
                            @foreach ($categ->equipos as $item)
                                <li class="list-group-item">
                                    <input class="form-check-input checkbox me-1 mt-3" name="equipos[]"
                                        data-id="{{ $item->id }}" type="checkbox" value="{{ $item->id }}"
                                        id="{{ $grupo->id }}-{{ $item->id }}">

                                    <label class="form-check-label stretched-link"
                                        for="{{ $grupo->id }}-{{ $item->id }}">{{ $item->nombre }}</label>
                                    <div class="avatar avatar-l ">
                                        <img class="rounded-circle mt-2"
                                            src="{{ asset('img/Escudo/') }}{{ $item->escudo }}" alt="" />
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <input type="hidden" id="equipos" name="EquipGrupo{{ $grupo->id }}" value="">
                        <input type="hidden" id="grupos" name="grupo" value="{{ $grupo->id }}">
                    </div>
                </div>
                <span class=""> Nro equipos en el {{ $grupo->nombre }}:
                    <label id="count">ds</label> </span>
            </div>
        @endforeach
    @endforeach
    <input type="hidden" id="idCategoria" value="{{ $categoria[0]->id }}">

    <div class="col-12 pt-5 text-center"><button class="btn btn-primary enviar" type="submit">Enviar</button></div>



</div>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        $(".checkbox").on('change', function(e) {
            e.preventDefault();


            let grup = $(this).parent().parent().parent().parent().parent().attr(
                'id'); // PARA SABER EL ID DEL DIV 

            let divs = $('.modal-body').find('div.col:not(#' + grup +
                ')'); // BUSCO TOS LOS DIV MENOS EL QUE ESTA EL CHECKBOX SELECCIONADO

            let valoresCheck = [];
            let count = [];

            if ($(this).is(':checked')) {
                $('.row').find('input[value = ' + this.value + ']').removeAttr('disabled');
                //BUSCO TODOS LOS CHECKS SELECCIONADOS
                $(this).parent().parent().find('input:checked').each(function(i, v) {
                    valoresCheck[i] = (this.value);


                    // RECORRO TODOS LOS DIV QUE DIFERENTES AL CHECKS QUE SELECCIONO
                    $(divs).each(function(i, sel) {
                        $(valoresCheck).each(function(a, e) {
                            $(sel).find('input[value != ' + e + ']').removeAttr(
                                'disabled');
                        });
                        $(valoresCheck).each(function(a, e) {
                            $(sel).find('input[value = ' + e + ']').attr(
                                'disabled', true);
                        });



                    });

                    count =(i++)+1;
                    
                    
                });
               $(this).parent().parent().parent().parent().parent().find('label#count').text(count);


            } else {
                $('.row').find('input[value = ' + this.value + ']').removeAttr('disabled');

            }
            let values = [];

            $(this).parent().parent().find('input:checked').each(function(i, v) {

                values[i] = (this.value);
            });

            $('input[name = EquipGrupo' + grup + ']').val(values);
        });
        $(document).on('click', '.enviar', function(e) {
            e.preventDefault();
            // let idEquipos = [];
            let idCategoria = $('#idCategoria').val();


            let idEquipos = [];
            let idGrupos = [];
            $('.row div.grupo').each(function(i, sel) {


                $(sel).find('input#equipos').each(function(a, v) {

                    idEquipos[i] = $(v).val();
                });
                $(sel).find('input#grupos').each(function(a, v) {
                    idGrupos[i] = $(v).val();

                });

            });

            $('.row div.grupo').each(function(i, sel) {
                let idEquipos = [];
                $(sel).find('input:checked').each(function(a, v) {

                    idEquipos[i] = $(v).val();
                });

            });
            // console.log(idEquipos);

            // return;
            Swal.fire({
                title: "Desea Agregar los equipos seleccionados.?",
                text: "Si los los grupos ya tienen equipos asignados, estos se borrarán y se asignaran los equipos seleccionados.",
                showCancelButton: true,
                confirmButtonText: "Si",
                cancelButtonText: 'No',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post("{{ route('agregar-grupos') }}", {
                            idEquipos: idEquipos,
                            idGrupos: idGrupos,
                            idCategoria: idCategoria,

                        })
                        .then(response => {


                            if (response.data.status == 200) {
                                $('.modal').modal('hide');
                                Swal.fire({
                                    title: "Grupos Creados!",
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
    });
</script>
