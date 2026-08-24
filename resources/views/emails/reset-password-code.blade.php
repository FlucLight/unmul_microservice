<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="520" cellpadding="0" cellspacing="0" style="max-width:520px; width:100%;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#FF7A00; border-radius:16px 16px 0 0; padding:28px 32px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:18px; font-weight:800; letter-spacing:1px; text-transform:uppercase;">Fakultas Teknik</h1>
                            <p style="margin:4px 0 0; color:#ffe4cc; font-size:11px; font-weight:600; letter-spacing:3px; text-transform:uppercase;">Universitas Mulawarman</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="background-color:#ffffff; padding:36px 32px;">
                            <h2 style="margin:0 0 6px; color:#0f172a; font-size:20px; font-weight:800;">Reset Password Akun 🔐</h2>
                            <p style="margin:0 0 24px; color:#64748b; font-size:14px; line-height:1.6;">
                                Halo <strong style="color:#0f172a;">{{ $user->name }}</strong>,<br>
                                Gunakan kode verifikasi di bawah ini untuk mengatur ulang password akun LMS Anda.
                            </p>

                            <!-- Kode Verifikasi -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="background-color:#fff7ef; border:2px dashed #FF7A00; border-radius:14px; padding:22px 16px;">
                                        <p style="margin:0 0 8px; color:#94a3b8; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase;">Kode Verifikasi Anda</p>
                                        <span style="display:inline-block; font-size:38px; font-weight:800; letter-spacing:10px; color:#FF7A00; font-family:'Courier New', monospace;">{{ $code }}</span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:20px 0 0; color:#64748b; font-size:13px; line-height:1.7;">
                                ⏳ Kode ini <strong style="color:#0f172a;">berlaku selama 60 menit</strong>.<br>
                                🛡️ Jangan bagikan kode ini kepada siapa pun — termasuk pihak yang mengaku sebagai admin.
                            </p>

                            <!-- Tombol -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:26px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/login') }}" style="display:inline-block; background-color:#FF7A00; color:#ffffff; font-size:14px; font-weight:700; text-decoration:none; padding:13px 36px; border-radius:12px;">Kembali ke Halaman Login</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:26px 0 0; color:#94a3b8; font-size:12px; line-height:1.7;">
                                Tidak merasa meminta reset password? Abaikan email ini — password Anda tetap aman dan tidak ada perubahan pada akun Anda.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#0f172a; border-radius:0 0 16px 16px; padding:22px 32px; text-align:center;">
                            <p style="margin:0; color:#cbd5e1; font-size:11px; line-height:1.8;">
                                <strong style="color:#ffffff;">LMS Fakultas Teknik UNMUL</strong><br>
                                Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
