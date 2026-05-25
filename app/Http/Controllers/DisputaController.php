<?php

namespace App\Http\Controllers;

use App\Models\Disputa;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputaController extends Controller
{
    private function comprobarAdmin()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'admin') {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_solicitud' => ['required', 'exists:solicitudes,id'],
            'motivo' => ['required', 'string'],
        ]);

        $solicitud = Solicitud::findOrFail($datos['id_solicitud']);

        if ($solicitud->estado !== 'aceptada') {
            return redirect()
                ->route('perfil')
                ->with('error', 'Solo se pueden reportar disputas sobre intercambios aceptados.');
        }

        if (
            $solicitud->id_solicitante !== Auth::id() &&
            $solicitud->id_propietario !== Auth::id()
        ) {
            abort(403);
        }

        $existeDisputa = Disputa::where('id_solicitud', $solicitud->id)->exists();

        if ($existeDisputa) {
            return redirect()
                ->route('perfil')
                ->with('error', 'Ya existe una disputa para este intercambio.');
        }

        Disputa::create([
            'id_solicitud' => $solicitud->id,
            'id_usuario_reporta' => Auth::id(),
            'motivo' => $datos['motivo'],
            'estado' => 'pendiente',
        ]);

        return redirect()
            ->route('perfil')
            ->with('success', 'Disputa reportada correctamente. El administrador revisará el caso.');
    }

    public function index()
    {
        $this->comprobarAdmin();

        $disputas = Disputa::with([
                'usuarioReporta',
                'solicitud.libroPedido',
                'solicitud.libroOfrecido',
                'solicitud.solicitante',
                'solicitud.propietario',
            ])
            ->orderByRaw("CASE WHEN estado = 'pendiente' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('admin.disputas', compact('disputas'));
    }

    public function resolve(Request $request, Disputa $disputa)
    {
        $this->comprobarAdmin();

        $datos = $request->validate([
            'respuesta_admin' => ['required', 'string'],
        ]);

        $disputa->update([
            'estado' => 'resuelta',
            'respuesta_admin' => $datos['respuesta_admin'],
            'fecha_resolucion' => now(),
        ]);

        return redirect()
            ->route('admin.disputas')
            ->with('success', 'Disputa resuelta correctamente.');
    }
}