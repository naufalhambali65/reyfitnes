<div style="font-family: Arial, sans-serif; color:#333; line-height:1.6;">

    <h2 style="margin-bottom: 20px;">Halo {{ $user->name }},</h2>

    <p>
        Berikut adalah <strong>QR Code Keanggotaan</strong> Anda.
        Gunakan QR ini untuk melakukan absensi saat masuk ke gym.
    </p>

    <p style="margin: 15px 0; background:#fff3cd; padding:12px; border-radius:6px; border-left:4px solid #ffca2c;">
        <strong>⚠ Penting:</strong>
        Jangan bagikan QR ini kepada orang lain, karena QR ini adalah identitas akses Anda.
    </p>

    <div style="text-align:center; margin-top:25px;">
        <img src="{{ $message->embed(storage_path('app/public/' . $qrPath)) }}" alt="QR Code Member"
            style="width:220px; border:1px solid #ddd; padding:10px; border-radius:8px; background:white;">
    </div>

    <br>

    <p>Terima kasih,<br><strong>Rey Fitness</strong></p>

</div>
