<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Solicitud;
use App\Models\Disputa;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $libros = Libro::where('id_usuario', $usuario->id)
            ->where('estado', 'disponible')
            ->get();

        $historial = Libro::where('id_usuario', $usuario->id)
            ->where('estado', 'intercambiado')
            ->get();

        $solicitudesEnviadas = Solicitud::with(['libroPedido', 'libroOfrecido'])
            ->where('id_solicitante', $usuario->id)
            ->latest()
            ->get();

        $solicitudesRecibidas = Solicitud::with(['libroPedido', 'libroOfrecido', 'solicitante'])
            ->where('id_propietario', $usuario->id)
            ->latest()
            ->get();

        $misDisputas = Disputa::with([
                'solicitud.libroPedido',
                'solicitud.libroOfrecido'
            ])
            ->where('id_usuario_reporta', $usuario->id)
            ->latest()
            ->get();

        $disputasRelacionadas = Disputa::whereHas('solicitud', function ($query) use ($usuario) {
                $query->where('id_solicitante', $usuario->id)
                      ->orWhere('id_propietario', $usuario->id);
            })
            ->get();

        $disputasPorSolicitud = [];

        foreach ($disputasRelacionadas as $disputa) {
            $disputasPorSolicitud[$disputa->id_solicitud] = $disputa->estado;
        }

        return view('perfil.index', compact(
            'usuario',
            'libros',
            'historial',
            'solicitudesEnviadas',
            'solicitudesRecibidas',
            'misDisputas',
            'disputasPorSolicitud'
        ));
    }
}