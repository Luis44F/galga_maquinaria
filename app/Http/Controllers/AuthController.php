<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirección basada en el rol del usuario
            switch($user->rol) {
                case 'vendedor':
                    return redirect()->route('dashboard.ventas');
                    break;
                    
                case 'cartera':
                    return redirect()->route('dashboard.cartera');
                    break;
                    
                case 'importaciones':
                    return redirect()->route('dashboard.importaciones');
                    break;
                    
                case 'despachos':
                    return redirect()->route('dashboard.despachos');
                    break;
                    
                case 'facturacion':
                    return redirect()->route('dashboard.facturacion');
                    break;
                    
                case 'admin':
                default:
                    return redirect()->route('dashboard');
                    break;
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}