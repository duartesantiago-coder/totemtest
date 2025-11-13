<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function form()
    {
        if (!session('registration.email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:5', 'regex:/^\d{5}$/'],
        ], [
            'code.regex' => 'El código debe contener 5 dígitos.',
            'code.size' => 'El código debe tener exactamente 5 caracteres.',
        ]);

        $email = session('registration.email');

        // Buscar el código de verificación
        $verification = DB::table('email_verifications')
            ->where('email', $email)
            ->where('verification_code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->withErrors(['code' => 'Código inválido o expirado.']);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $verification->name,
            'email' => $verification->email,
            'password' => $verification->password,
        ]);

        // Eliminar el registro de verificación
        DB::table('email_verifications')->where('email', $email)->delete();

        // Limpiar sesión
        session()->forget(['registration.email', 'registration.name']);

        // Iniciar sesión automáticamente
        auth()->login($user);

        return redirect('/')->with('success', '¡Bienvenido! Tu cuenta ha sido verificada.');
    }

    public function resend(Request $request)
    {
        $email = session('registration.email');

        if (!$email) {
            return redirect()->route('register');
        }

        // Obtener el registro de verificación
        $verification = DB::table('email_verifications')
            ->where('email', $email)
            ->first();

        if (!$verification) {
            return redirect()->route('register');
        }

        // Generar nuevo código
        $code = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);

        // Actualizar
        DB::table('email_verifications')
            ->where('email', $email)
            ->update([
                'verification_code' => $code,
                'expires_at' => now()->addMinutes(15),
            ]);

        // Enviar email
        Mail::to($email)->send(new VerificationCodeMail($email, $code));

        return back()->with('success', 'Código reenviado a tu correo.');
    }
}
