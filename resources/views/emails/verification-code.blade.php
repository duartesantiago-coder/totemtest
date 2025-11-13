<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #0ea5e9 0%, #34d399 100%); color: white; padding: 20px; border-radius: 8px; text-align: center;">
        <h1 style="margin: 0; font-size: 28px;">M.I.G.A</h1>
        <p style="margin: 5px 0; font-size: 14px;">Sistema de Horarios Escolar</p>
    </div>

    <div style="background: #f8fbff; padding: 30px; border-radius: 8px; margin-top: 20px;">
        <h2 style="color: #0ea5e9; margin-top: 0;">¡Bienvenido a M.I.G.A!</h2>
        
        <p style="color: #333; line-height: 1.6;">
            Recibiste este correo porque intentaste registrarte con <strong>{{ $email }}</strong>.
        </p>

        <p style="color: #333; line-height: 1.6;">
            Tu código de verificación es:
        </p>

        <div style="background: white; border: 2px solid #0ea5e9; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0;">
            <span style="font-size: 48px; font-weight: bold; color: #0ea5e9; letter-spacing: 10px;">{{ $code }}</span>
        </div>

        <p style="color: #666; font-size: 12px;">
            Este código expira en 15 minutos. Si no solicitaste este registro, puedes ignorar este correo.
        </p>
    </div>

    <div style="text-align: center; color: #999; font-size: 12px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
        <p>© 2025 M.I.G.A - Todos los derechos reservados</p>
    </div>
</div>
