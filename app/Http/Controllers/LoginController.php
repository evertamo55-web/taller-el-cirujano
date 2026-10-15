<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirige según su rol
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Procesa el intento de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Intenta autenticar al usuario
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        // Si falla, regresa con error
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Redirige al usuario según su rol.
     */
    private function redirectByRole()
    {
        $rol = Auth::user()->rol;

        return match ($rol) {
            'propietario' => redirect()->route('admin.ganancias'),
            'operario'    => redirect()->route('ordenes.index'),
            'tecnico'     => redirect()->route('tecnico.dashboard'),
            default       => redirect('/'),
        };
    }
}