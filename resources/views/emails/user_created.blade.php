<div style="font-family: Arial, sans-serif; color:#333; line-height:1.6;">
    <h2 style="text-align:center; margin-bottom: 20px;">🎉 Akun Anda Berhasil Dibuat</h2>

    <p>Halo <strong>{{ $user->name }}</strong>,</p>

    <p>Selamat! Akun Anda pada <strong>Rey Fitness</strong> telah berhasil dibuat.
        Berikut detail login Anda:</p>

    <table cellpadding="8" cellspacing="0" style="width:100%; background:#f7f7f7; border-radius:8px; margin-top:15px;">
        <tr>
            <td style="width:30%; font-weight:bold;">Email</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Password</td>
            <td>{{ $rawPassword }}</td>
        </tr>
    </table>

    <p style="margin-top:20px;">
        Silakan login menggunakan email dan password tersebut.
        Demi keamanan, segera lakukan perubahan password setelah berhasil masuk.
    </p>

    <br>

    <p>Terima kasih,<br><strong>Rey Fitness</strong></p>
</div>
