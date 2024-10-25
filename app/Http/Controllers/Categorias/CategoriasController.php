<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CategoriasController extends Controller
{
    use peticionTraits;
    public function index()
    {

        return view('Content.Categorias.Categorias');
    }

    public function datatableCategorias()
    {

        $categorias = $this->peticicion('categorias', 'get', []);

        if ($categorias->status == 500) {
            $categorias = [];
        } else {

            $categorias = $categorias->data;
            rsort($categorias);
        }



        $categoria = collect($categorias)->map(function ($categoria, $index) {
            // dd($categoria, $index);

            $equipos = [];
            foreach ($categoria->equipos as $equipo) {
                array_push($equipos, $equipo->nombre . ' ');
            }

            // dd($categoria, $index);

            return (object)[
                'INDEX' => $index + 1,
                'id' => $categoria->id,
                'NOMBRE' => $categoria->nombre,
                'ALIAS' => $categoria->alias,
                'GRUPOS' => $categoria->grupos,
                'N_GRUPOS' => $categoria->cant_grupos,
                'CANTIDAD_EQUIPOS' => count($categoria->equipos),
                'EQUIPOS' => $equipos,
            ];
        });

        return DataTables::of($categoria)
            ->addColumn('BUTTONS', function ($prod) {
                $btn =
                    '<div>
                    <button class="btn btn-link p-0 editCateg" type="button" data-idcateg="' . $prod->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                        <span class="text-500 fas fa-edit"></span>
                    </button>
                    <button class="btn btn-link p-0 ms-2 deleteCateg" type="button" data-idcateg="' . $prod->id . '" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                    <span class="text-500 fas fa-trash-alt"></span>
                    </button>
                </div>';

                return $btn;
            })
            ->rawColumns(['BUTTONS'])
            ->make(true);
    }

    public function viewCrearCategorias(Request $request)
    {

        $equipos = $this->peticicion('equipos', 'get', []);


        $equipos = $equipos->data;
        // dd($equipos);
        return view('Content.Categorias.FormAgregarCategorias', compact('equipos'));
    }

    public function agregarCategorias(Request $request)
    {


        // dd($request->all());
        $crear = $this->peticicion('categorias/crearCategoria', 'post', $request->all());
     
        // dd($status);
        return response()->json(['message' => $crear->data->message, 'status' => $crear->status],$crear->status);
    }

    public function viewEditarCategorias(Request $request)
    {

        $categoria = $this->peticicion('categorias', 'get', ['id_categoria' => $request->idCateg]);
        $equipos = $this->peticicion('equipos', 'get', []);


        $equipos = $equipos->data;

        $categoria = $categoria->data;
        // dd($categoria,$request->idCateg);
        return view('Content.Categorias.FormAgregarCategorias', compact('categoria', 'equipos'));
    }

    public function EditarCategorias(Request $request)
    {

        // dd($request->all());
        $editar = $this->peticicion('categorias/editarCategoria', 'post', $request->all());
        // dd($editar);


        if ($editar->status == 200) {
            $status = 'success';
            $message = $editar->data->message;
        } else {
            $status = 'error';
            $message = 'error ' . $editar->status;
        }
        // dd($status);
        return redirect()->route('viewLista-categorias')->with($status, $message);
    }

    public function deleteCategorias(Request $request)
    {

        // dd($request->all());
        $editar = $this->peticicion('categorias/deleteCategoria', 'post',  ['id_categoria' => $request->idCateg]);
        // dd($editar);


        if ($editar->status == 200) {
            $status = 'success';
            $message = $editar->data->message;
        } else {
            $status = 'error';
            $message = 'error ' . $editar->status;
        }
        // dd($status);
        return response()->json(['message' => $message, 'status' => $status]);
    }
}
