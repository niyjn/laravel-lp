<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:cliente,email'],
            'senha' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $cliente = Cliente::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'senha_hash' => Hash::make($validated['senha']),
            'role' => 'usuario',
            'is_admin' => false,
        ]);

        event(new Registered($cliente));

        Auth::login($cliente);

        $request->session()->regenerate();

        return redirect()->route('perfil');
    }
}
