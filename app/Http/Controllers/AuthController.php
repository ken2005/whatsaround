<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            Log::info('Utilisateur connecté avec succès', ['email' => $request->email]);
            return redirect()->intended('/');
        }

        Log::warning('Tentative de connexion échouée', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout()
        {
            $email = Auth::user()->email;
            Auth::logout();
            Log::info('Utilisateur déconnecté', ['email' => $email]);
            return redirect('/');
        }
    
    public function register(Request $request){
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9_ ]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);

        Auth::login($user);
        Log::info('Nouvel utilisateur inscrit', ['email' => $user->email, 'name' => $user->name]);

        return redirect('/');
    }    
}
