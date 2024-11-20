<?php

namespace App\Http\Controllers\Grupos;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;

class GruposController extends Controller
{
    use peticionTraits;

    public function index()
    {
        $categorias = $this->peticicion('categorias', 'get', []);
        $categorias = $categorias->data;

        // dd($categorias);
        return view('Content.Grupos.Grupos', compact('categorias'));
    }
    public function viewCrearCrupos(Request $request)
    {
        $id_categoria = $request->idCateg;
        $categoria = $this->peticicion('categorias', 'get', ['id_categoria' => $request->idCateg]);
        $categoria = $categoria->data;
        // dd($categoria);
        return view('Content.Grupos.DefinirGrupos', compact('categoria'));
    }
    public function agregarGrupos(Request $request)
    {
        // dd($request->all());
        $categorias = $this->peticicion('grupos/agregar', 'get', $request->all());
        
        $message =  $categorias->data->message;
        $status = $categorias->data->status;
        // dd($categorias);

        return response()->json(['message' => $message, 'status' => $status], $status);
        // dd($categorias);
    }
}
