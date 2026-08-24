<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="520" cellpadding="0" cellspacing="0" style="max-width: 520px; width: 100%; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #e65100; padding: 28px 32px; text-align: left; border-bottom: 3px solid #bf360c;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 16px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Fakultas Teknik</h1>
                            <p style="margin: 4px 0 0; color: #ffe0b2; font-size: 12px; font-weight: 500; letter-spacing: 1px;">UNIVERSITAS MULAWARMAN</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin: 0 0 16px; color: #1e293b; font-size: 18px; font-weight: 700;">Permintaan Reset Password</h2>
                            
                            <p style="margin: 0 0 20px; color: #475569; font-size: 14px; line-height: 1.6;">
                                Yth. <strong>{{ $user->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 24px; color: #475569; font-size: 14px; line-height: 1.6;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun LMS Anda. Gunakan kode verifikasi berikut untuk melanjutkan proses pembaruan kata sandi:
                            </p>

                            <!-- Kode Verifikasi -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center" style="background-color: #fff8e1; border: 1px solid #ffe082; border-radius: 6px; padding: 20px;">
                                        <div style="color: #5d4037; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px;">Kode Verifikasi</div>
                                        <div style="font-size: 32px; font-weight: 700; letter-spacing: 8px; color: #e65100; font-family: 'Courier New', Courier, monospace;">{{ $code }}</div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 24px; color: #475569; font-size: 13px; line-height: 1.6;">
                                Kode ini hanya berlaku selama <strong>60 menit</strong>. Demi keamanan akun Anda, mohon tidak memberitahukan kode ini kepada siapa pun, termasuk pihak pengelola sistem.
                            </p>

                            <!-- Action Area -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td align="left">
                                        <a href="{{ url('/login') }}" style="display: inline-block; background-color: #0f172a; color: #ffffff; font-size: 13px; font-weight: 600; text-decoration: none; padding: 12px 24px; border-radius: 6px;">Kembali ke Halaman Login</a>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 0 0 20px;">

                            <p style="margin: 0; color: #94a3b8; font-size: 12px; line-height: 1.6;">
                                Apabila Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini. Kata sandi Anda akan tetap aman dan tidak mengalami perubahan.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 32px; text-align: left;">
                            <p style="margin: 0; color: #64748b; font-size: 11px; line-height: 1.6;">
                                Tim Layanan Komputasi & Sistem Informasi<br>
                                Fakultas Teknik, Universitas Mulawarman<br>
                                <span style="color: #94a3b8;">Email ini dikirimkan secara otomatis oleh sistem, mohon untuk tidak membalas email ini.</span>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>