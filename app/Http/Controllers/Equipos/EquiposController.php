<?php

namespace App\Http\Controllers\Equipos;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;

class EquiposController extends Controller
{
    use peticionTraits;

    public function index()
    {

        $categorias = $this->peticicion('categorias', 'get', []);
        $equipos = $this->peticicion('equipos', 'get', []);
        // dd($categorias, $equipos);

        $categorias = $categorias['data'];
        $equipos = $equipos['data'];

        return view('Content.Equipos.Equipos', compact('categorias','equipos'));

    }
}
