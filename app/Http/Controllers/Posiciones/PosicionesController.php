<?php

namespace App\Http\Controllers\Posiciones;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;

class PosicionesController extends Controller
{
    use peticionTraits;
    public function index(){
        $categorias = $this->peticicion('posiciones', 'get', []);
        $categorias = $categorias->data;
        // dd($categorias->posiciones);

        return view('Content.Posiciones.TablaPosiciones', compact('categorias'));

    }
}
