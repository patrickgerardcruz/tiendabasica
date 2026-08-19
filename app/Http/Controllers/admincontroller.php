<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar formulario de acceso
    public function login()
    {
        return view('admin.login');
    }

    // Verificar la clave
    public function autenticar(Request $request)
    {
        $request->validate([
            'clave' => 'required',
        ]);

        if ($request->clave === env('ADMIN_PASSWORD')) {
            session(['es_admin' => true]);
            return redirect()->route('productos.index')->with('exito', 'Acceso concedido. Ya puedes administrar el catálogo.');
        }

        return back()->withErrors(['clave' => 'Clave incorrecta']);
    }

    // Cerrar sesión de admin
    public function salir()
    {
        session()->forget('es_admin');
        return redirect()->route('productos.index')->with('exito', 'Sesión de administrador cerrada');
    }
}