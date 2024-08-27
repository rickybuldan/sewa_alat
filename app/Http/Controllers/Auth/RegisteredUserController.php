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
use Illuminate\Support\Facades\Log;
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
            'name' => ['required', 'string', 'max:255'],
            // 'nama_perusahaan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nama_perusahaan' => $request->nama_perusahaan ?? "Perorangan",
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        // event(new Registered($user));

        // Auth::login($user);
        try {
            // Mengirimkan email verifikasi
            $user->sendEmailVerificationNotification();
            Log::info('Email verification sent to: ' . $user->email);
            return back()->with('status', 'Email verifikasi telah dikirim.');
        } catch (\Exception $e) {
            Log::error('Failed to send email verification: ' . $e->getMessage());
        }

        return redirect()->route('verification.notice');
        
    }
}
