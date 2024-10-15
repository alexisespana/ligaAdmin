<div class="row">
    @foreach ($categoria as $categ)
        <div class="col p-2">
            <div class="card border h-100 border-primary">
                <div class="card-body">
                    {{-- <div class="card-title pb-2">{{ $categ->nombre }}</div> --}}
                    <select class="selectpicker" name="categorias[]" data-live-search="true" multiple show-tick
                        data-width="100%">
                        @foreach ($categ->equipos as $item)
                            <option data-subtext="{{ $item->abr }}" value="{{ $item->id }}">
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endforeach
    <input type="hidden" id="idGrupo" value="{{ $idGrupo }}">
    <input type="hidden" id="idCategoria" value="{{ $categoria[0]->id }}">

    <div class="col-12 pt-5 text-center"><button class="btn btn-primary enviar" type="submit">Enviar</button></div>



</div>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        let idEquipos = [];
        let idGrupo = $('#idGrupo').val();
        let idCategoria = $('#idCategoria').val();
        $(document).on('click', '.enviar', function(e) {
            $('.selectpicker :selected').each(function(i, sel) {
                idEquipos[i] = $(sel).val();

            });

            axios.post("{{ route('agregar-grupos') }}", {
                    idEquipos: idEquipos,
                    idGrupo: idGrupo,
                    idCategoria: idCategoria,

                })
                .then(response => {
                    if (response.status == 200) {
                        $('.modal').modal('hide');
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
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
                            html: '<ul class="text-left">' + errores + '</ul>',
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

        });
    });
</script>
