<div class="container">

    @foreach ($jornada as $jorn)
        <input class="form-control" id="idJornada" name="idJornada" type="hidden" value="{!! isset($jornada) ? $jorn->id : '' !!}">

        <div class="row g-3">
            <div class="col-md-6">
                <label for="nombre">Nombre de la Categoría</label>
                <input class="form-control" id="nombre" name="nombre" type="text" placeholder=""
                    value="{!! isset($jornada) ? $jorn->nombre : '' !!}">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Default input style</label>
                <input class="form-control" placeholder="Pick a date" id="fecha" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="status">Status de la Jornada</label>
                <select class="form-select" aria-label="Default select example" id="status">
                    @foreach ($status as $item)
                        <option {!! isset($jornada) && $jorn->vigente === $item->value ? 'selected ' : ' ' !!}value="{{ $item->value }}">{{ $item->status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 pt-3 pb-2 text-center">
                <button class="btn btn-primary {!! isset($jornada) ? 'editar-jornada' : 'agregar-jornada' !!}" type="button">Enviar</button>
            </div>
        </div>
    @endforeach
</div>
<script>
    $(document).ready(function() {

        $(document).on('click', '.editar-jornada', function(e) {

            let idJornada = $('#idJornada').val();
            let fecha = $('#fecha').val();
            let status = $('#status').val();

            if (fecha == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Debe seleccionar una fecha para la jornada.',
                });
                return false;
            }
            e.preventDefault();
            Swal.fire({
                title: "¿Desea modificar la Jornada?",
                showCancelButton: true,
                confirmButtonText: "Si",
                cancelButtonText: 'No',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios.post("{{ route('modificar-jornada') }}", {
                            idJornada: idJornada,
                            fecha: fecha,
                            status: status,

                        })
                        .then(response => {


                            if (response.data.status == 200) {
                                $('.modal').modal('hide');
                                Swal.fire({
                                    title: "Jornada Modificada!",
                                    html: response.data.message,
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


        $("#fecha").flatpickr({
            // enableTime: true,
            dateFormat: "d/m/Y",
            minDate: "today",
            defaultDate: "today",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                        'Sábado'
                    ],
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct',
                        'Nov', 'Dic'
                    ],
                    longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                },
            },

        });
    });
</script>
