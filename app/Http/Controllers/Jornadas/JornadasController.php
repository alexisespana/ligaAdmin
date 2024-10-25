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
        return view('Content.Jornadas.Jornadas', compact('jornadas'));
    }

    public function viewCrearJornadas(Request $request)
    {

        // dd($request->all());
        $jornada = $this->peticicion('Jornadas/buscarJornadas', 'post', $request->all());
        $jornada = $jornada->data;

        $status = [

            (object)['status' => 'Completado', 'value' => '0'],
            (object)['status' => 'Vigente', 'value' => '1'],
            (object)['status' => 'Pendiente', 'value' => '2'],
            (object)['status' => 'Suspendido', 'value' => '3'],
        ];


        return view('Content.Jornadas.CrearJornadas', compact('jornada', 'status'));
    }

    public function modificarJornada(Request $request)
    {
        // dd($request->all());
        $jornada = $this->peticicion('Jornadas/modificarJornadas', 'post', $request->all());
        $message =  $jornada->data->message;
        $status = $jornada->status;

        return response()->json(['message' => $message, 'status' => $status], $status);
    }
}
