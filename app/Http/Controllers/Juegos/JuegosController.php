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

        return view('Content.Juegos.Juegos', compact('juegos','categorias'));
    }
}
