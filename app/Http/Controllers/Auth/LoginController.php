<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar formulario de acceso
    public function mostrarLogin()
    {
        return view('admin.login');
    }

    // Verificar credenciales
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return redirect()->route('productos.index')->with('exito', 'Bienvenido, has ingresado como administrador');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas'])->onlyInput('email');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('productos.index')->with('exito', 'Sesión cerrada correctamente');
    }
}