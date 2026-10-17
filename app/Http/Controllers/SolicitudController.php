<?php

namespace App\Http\Controllers;

use App\Models\SolicitudSoporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudSoporte::orderBy('id', 'desc')->get();
        return view('solicitudes', compact('solicitudes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'solicitante'  => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'prioridad'    => 'required|in:Baja,Media,Alta',
        ]);

        SolicitudSoporte::create([
            'solicitante'  => $request->solicitante,
            'departamento' => $request->departamento,
            'descripcion'  => $request->descripcion,
            'prioridad'    => $request->prioridad,
            'estado'       => 'Pendiente',
        ]);

        return redirect()->back()->with('exito', 'Solicitud registrada correctamente con estado Pendiente.');
    }
}