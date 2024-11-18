<?php

namespace App\Http\Controllers\Juegos;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    use peticionTraits;
    public function index()
    {
        $juego = $this->peticicion('juegos', 'get', []);
        // dd($juego);
        $juegos = $juego->data->juegos;
        $categorias = $juego->data->categorias;

        return view('Content.Juegos.Juegos', compact('juegos', 'categorias'));
    }
    public function crearJuegos(Request $request)
    {
        $juego = $this->peticicion('juegos/crearJuegos', 'get', []);
        // dd($juego);
        $categorias = $juego->data->categorias;
        $sedes = $juego->data->sedes;
        $arbitros = $juego->data->arbitros;

        return view('Content.Juegos.CrearJuegos', compact('categorias', 'sedes', 'arbitros'));
    }

    public function registrarJuegos(Request $request)
    {
        $registrar = $this->peticicion('juegos/registrarJuegos', 'post', $request->all());
        dd($registrar); //
        if ($registrar->status == 200) {
            $status = 'success';
            $message = $registrar->data->message;
        } else {
            $status = 'error';
            $message = 'error ' . $registrar->status;
        }
        return redirect()->route('viewLista-categorias')->with($status, $message);


    }
}
