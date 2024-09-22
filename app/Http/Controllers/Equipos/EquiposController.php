<?php

namespace App\Http\Controllers\Equipos;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class EquiposController extends Controller
{
    use peticionTraits;

    public function index()
    {

        return view('Content.Equipos.Equipos');
    }
    public function datatableEquipos()
    {

        $equipos = $this->peticicion('equipos', 'get', []);



        $equipos = collect($equipos->data)->map(function ($equipo, $index) {

            $categorias = [];
            foreach ($equipo->categoria as $cat) {
                array_push($categorias, $cat->nombre . ' ');
            }

            // dd($equipo, $index);

            return (object)[
                'INDEX' => $index + 1,
                'id' => $equipo->id,
                'ESCUDO' => $equipo->escudo,
                'NOMBRE' => $equipo->nombre,
                'ALIAS' =>  $equipo->abr,
                'COLOR1' =>  $equipo->color,
                'COLOR2' =>  $equipo->color_text,
                'CANTIDAD_CATEGORIA' =>  count($equipo->categoria),
                'CATEGORIAS' => $categorias,
            ];
        });

        return DataTables::of($equipos)
            ->addColumn('BUTTONS', function ($prod) {
                $btn =
                    '<div>
                    <button class="btn btn-link p-0 editEquipo" type="button" data-idEquipo="' . $prod->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                        <span class="text-500 fas fa-edit"></span>
                    </button>
                    <button class="btn btn-link p-0 ms-2 deleteEquipo" type="button" data-idEquipo="' . $prod->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                    <span class="text-500 fas fa-trash-alt"></span>
                    </button>
                </div>';

                return $btn;
            })
            ->rawColumns(['BUTTONS'])
            ->make(true);
    }
    public function viewCrearEquipos(Request $request)
    {

        $categorias = $this->peticicion('categorias', 'get', []);


        $categorias = $categorias->data;
        // dd($categorias);
        return view('Content.Equipos.FormAgregarEquipos', compact('categorias'));
    }
    public function agregarEquipos(Request $request)
    {


        // dd($request->all());
        $crear = $this->peticicion('equipos/crearEquipos', 'post', $request->all());
        // dd($crear);

        $status = 'success';
        $message = $crear->data->message;
        if ($crear->status == 500) {
            $status = 'error';
            $message = $crear->data->message;
        }
        // dd($status);
        return redirect()->route('viewLista-equipos')->with($status, $message);
    }
    public function viewEditarEquipo(Request $request)
    {
        // dd($request->all());
        $equipo = $this->peticicion('equipos', 'get', ['id_equipo' => $request->idEquipo]);
        $categorias = $this->peticicion('categorias', 'get', []);


        $equipo = $equipo->data;

        $categorias = $categorias->data;
        // dd($equipo,$categorias);
        return view('Content.Equipos.FormAgregarEquipos', compact('categorias', 'equipo'));
    }

    public function EditarEquipo(Request $request)
    {

        // dd($request->all());
        $editar = $this->peticicion('equipos/editarEquipos', 'post', $request->all());
        // dd($editar);


        if ($editar->status == 200) {
            $status = 'success';
            $message = $editar->data->message;
        } else {
            $status = 'error';
            $message = 'error ' . $editar->status;
        }
        // dd($status);
        return redirect()->route('viewLista-equipos')->with($status, $message);
    }
}
