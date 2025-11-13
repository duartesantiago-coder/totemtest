@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #0ea5e9 0%, #34d399 100%); color: white; text-align: center;">
                    <h4 style="margin: 0;">Verificar Correo Electrónico</h4>
                </div>

                <div class="card-body" style="padding: 40px;">
                    <p style="text-align: center; color: #666; margin-bottom: 30px;">
                        Hemos enviado un código de <strong>5 cifras</strong> a:<br>
                        <strong style="color: #0ea5e9; font-size: 16px;">{{ session('registration.email') }}</strong>
                    </p>

                    <form method="POST" action="{{ route('verify-email.check') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="code" style="font-weight: 600; color: #333;">Código de Verificación</label>
                            <input
                                type="text"
                                id="code"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                placeholder="Ingresa los 5 dígitos"
                                maxlength="5"
                                autocomplete="off"
                                style="text-align: center; font-size: 24px; letter-spacing: 8px; padding: 15px;"
                                required
                                autofocus
                            >
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #0ea5e9 0%, #34d399 100%); border: none; padding: 12px; font-size: 16px; font-weight: 600;">
                            Verificar
                        </button>
                    </form>

                    <hr style="margin: 30px 0;">

                    <div style="text-align: center;">
                        <p style="color: #666; margin-bottom: 10px;">¿No recibiste el código?</p>
                        <form method="POST" action="{{ route('verify-email.resend') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link" style="color: #0ea5e9; text-decoration: none; padding: 0;">
                                Reenviar código
                            </button>
                        </form>
                    </div>

                    <p style="text-align: center; color: #999; font-size: 12px; margin-top: 20px;">
                        El código expira en <strong>15 minutos</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
