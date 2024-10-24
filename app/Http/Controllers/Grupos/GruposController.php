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
        // dd($categorias);
        if ($categorias->data->status == 200) {
            $status = 'success';
            $message = $categorias->data->message;
        } else {
            $status = 'error';
            $message = 'error ' . $categorias->status;
        }
        // dd($categorias);
        return redirect()->route('viewLista-grupos')->with($status, $message);
    }
}
