<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'apellido' => ['nullable', 'string', 'max:100'],            
            'telefono' => ['nullable', 'string', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
            'documento_id' => ['nullable', 'exists:documento_id,id'], // Permitimos que sea nullable           
            'numeroDoc' => ['nullable', 'string', 'max:25'],
            'direccion' => ['nullable', 'string', 'max:150'],            
            'vigente' => ['nullable', 'integer'],
            'email_verified_at' => ['nullable', 'date'],
            'remember_token' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,        
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'documento_id' => $request->documento_id,            
            'numeroDoc' => $request->numeroDoc,        
            'direccion' => $request->direccion,
            'vigente' => $request->vigente,
            'email_verified_at' => $request->email_verified_at,
            'remember_token' => $request->remember_token,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
