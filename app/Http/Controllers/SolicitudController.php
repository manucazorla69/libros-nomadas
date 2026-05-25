<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'id_libro' => ['required', 'exists:libros,id'],
            'id_libro_ofrecido' => ['required', 'exists:libros,id'],
            'mensaje' => ['required', 'string'],
        ]);

        $libroSolicitado = Libro::where('id', $datos['id_libro'])
            ->where('estado', 'disponible')
            ->firstOrFail();

        $libroOfrecido = Libro::where('id', $datos['id_libro_ofrecido'])
            ->where('id_usuario', Auth::id())
            ->where('estado', 'disponible')
            ->firstOrFail();

        if ($libroSolicitado->id_usuario === Auth::id()) {
            return redirect()
                ->route('libros.show', $libroSolicitado)
                ->with('error', 'No puedes solicitar tu propio libro.');
        }

        if ($libroSolicitado->id === $libroOfrecido->id) {
            return redirect()
                ->route('libros.show', $libroSolicitado)
                ->with('error', 'No puedes ofrecer el mismo libro que solicitas.');
        }

        $solicitudExistente = Solicitud::where('id_libro', $libroSolicitado->id)
            ->where('id_solicitante', Auth::id())
            ->where('estado', 'pendiente')
            ->exists();

        if ($solicitudExistente) {
            return redirect()
                ->route('perfil')
                ->with('error', 'Ya tienes una solicitud pendiente para este libro.');
        }

        Solicitud::create([
            'id_libro' => $libroSolicitado->id,
            'id_libro_ofrecido' => $libroOfrecido->id,
            'id_solicitante' => Auth::id(),
            'id_propietario' => $libroSolicitado->id_usuario,
            'mensaje' => $datos['mensaje'],
            'estado' => 'pendiente',
        ]);

        return redirect()
            ->route('perfil')
            ->with('success', 'Solicitud enviada correctamente.');
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $datos = $request->validate([
            'accion' => ['required', 'in:aceptar,rechazar'],
        ]);

        if ($solicitud->id_propietario !== Auth::id()) {
            abort(403);
        }

        if ($solicitud->estado !== 'pendiente') {
            return redirect()
                ->route('perfil')
                ->with('error', 'Esta solicitud ya fue gestionada.');
        }

        if ($datos['accion'] === 'rechazar') {
            $solicitud->update([
                'estado' => 'rechazada',
            ]);

            return redirect()
                ->route('perfil')
                ->with('success', 'Solicitud rechazada correctamente.');
        }

        DB::transaction(function () use ($solicitud) {
            $libroSolicitado = Libro::findOrFail($solicitud->id_libro);
            $libroOfrecido = Libro::findOrFail($solicitud->id_libro_ofrecido);

            if ($libroSolicitado->estado !== 'disponible' || $libroOfrecido->estado !== 'disponible') {
                throw new \Exception('Uno de los libros ya no está disponible.');
            }

            $solicitud->update([
                'estado' => 'aceptada',
            ]);

            /*
             * Intercambiamos propietarios:
             * - El solicitante recibe el libro solicitado.
             * - El propietario recibe el libro ofrecido.
             */
            $libroSolicitado->update([
                'id_usuario' => $solicitud->id_solicitante,
                'estado' => 'intercambiado',
            ]);

            $libroOfrecido->update([
                'id_usuario' => $solicitud->id_propietario,
                'estado' => 'intercambiado',
            ]);

            /*
             * Rechazamos otras solicitudes pendientes relacionadas
             * con cualquiera de los dos libros.
             */
            Solicitud::where('id', '!=', $solicitud->id)
                ->where('estado', 'pendiente')
                ->where(function ($query) use ($libroSolicitado, $libroOfrecido) {
                    $query->where('id_libro', $libroSolicitado->id)
                        ->orWhere('id_libro_ofrecido', $libroSolicitado->id)
                        ->orWhere('id_libro', $libroOfrecido->id)
                        ->orWhere('id_libro_ofrecido', $libroOfrecido->id);
                })
                ->update([
                    'estado' => 'rechazada',
                ]);
        });

        return redirect()
            ->route('perfil')
            ->with('success', 'Solicitud aceptada. El intercambio se ha completado.');
    }
}