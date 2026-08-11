<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     *
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{8,15}$/'],
            'calle' => ['required', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:100'],
            'codigo_postal' => ['required', 'string', 'max:20'],
            'pais' => ['required', 'string', 'max:100'],
        ], [
            'telefono.regex' => 'El teléfono debe tener entre 9 y 15 dígitos, solo números (sin espacios, guiones ni el prefijo +).',
        ]);

        $user = User::create([
            'nombre' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'calle' => $request->calle,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
            'pais' => $request->pais,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
