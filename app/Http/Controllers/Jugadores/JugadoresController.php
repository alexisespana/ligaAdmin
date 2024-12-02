<?php

namespace App\Http\Controllers\Jugadores;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JugadoresController extends Controller
{
    use peticionTraits;
    public function index()
    {
        $categorias = $this->peticicion('categorias', 'get', []);
        // dd($categorias);
        $categorias = $categorias->data;
        return view('Content.Jugadores.Jugadores', compact('categorias'));
    }

    public function datatableJugadores()
    {
        $jugadores = $this->peticicion('jugadores/', 'get', []);
        $jugadores = $jugadores->data;
        // dd($jugadores);
        $jugad = collect($jugadores)->map(function ($jugador, $index) {

            // dd($index);
            return (object)[
                'INDEX' => $index + 1,
                "id" => $jugador->id,
                "NOMBRE" => $jugador->nombre,
                "APELLIDOS" => $jugador->apellidos,
                "CEDULA" => $jugador->cedula,
                "POSICION" => $jugador->posicion,
                "FECHA_NACIMIENTO" => $jugador->fecha_nacimiento,
                "TELEFONO" => $jugador->telefono,
                "DIRECCION" => $jugador->direccion,
                "IMAGEN" => $jugador->imagen,

            ];
        });
        return DataTables::of($jugad)
        ->addColumn('BUTTONS', function ($jug) {
            $btn =
                '<div>
                <button class="btn btn-link p-0 editCateg" type="button" data-idcateg="' . $jug->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                    <span class="text-500 fas fa-edit"></span>
                </button>
                <button class="btn btn-link p-0 ms-2 deleteCateg" type="button" data-idcateg="' . $jug->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                <span class="text-500 fas fa-trash-alt"></span>
                </button>
            </div>';

            return $btn;
        })
        ->rawColumns(['BUTTONS'])
        ->make(true);
    }
}
