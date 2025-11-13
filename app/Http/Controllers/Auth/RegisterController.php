<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@esim\.edu\.ar$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.regex' => 'El correo debe pertenecer al dominio @esim.edu.ar',
            'email.unique' => 'Este correo ya está registrado.',
        ]);
    }

    public function register(Request $data)
    {
        $this->validator($data->all())->validate();

        // Generar código de 5 cifras
        $code = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);

        // Guardar en tabla temporal
        DB::table('email_verifications')->updateOrCreate(
            ['email' => $data->email],
            [
                'name' => $data->name,
                'password' => Hash::make($data->password),
                'verification_code' => $code,
                'expires_at' => now()->addMinutes(15),
            ]
        );

        // Enviar email con código
        Mail::to($data->email)->send(new VerificationCodeMail($data->email, $code));

        // Guardar en sesión
        session([
            'registration.email' => $data->email,
            'registration.name' => $data->name,
        ]);

        return redirect()->route('verify-email.form');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
