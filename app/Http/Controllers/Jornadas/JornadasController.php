<?php

namespace App\Http\Controllers\Jornadas;

use App\Http\Controllers\Controller;
use App\Traits\peticionTraits;
use Illuminate\Http\Request;

class JornadasController extends Controller
{
    use peticionTraits;
    public function index(Request $request)
    {
        $jornadas = $this->peticicion('Jornadas', 'get', []);

        // dd($jornadas);
        $jornadas = $jornadas->data;
        return view('Content.Jornadas.Jornadas',compact('jornadas'));

        dd($request->all());
    }
}
