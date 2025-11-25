<h2>Halo {{ $user->name }},</h2>

<p>Berikut adalah QR Code keanggotaan Anda.</p>
<p>Gunakan QR ini untuk melakukan absensi di gym.</p>

<p>
    <strong>Catatan:</strong>
    Jangan bagikan QR ini kepada orang lain.
</p>

{{-- <img src="{{ asset('storage/' . $qrPath) }}" style="width:200px;margin-top:20px;" /> --}}
<img src="{{ $message->embed(storage_path('app/public/' . $qrPath)) }}" alt="QR Code" width="250">

<br><br>
<p>Terima kasih,<br><strong>Rey Fitness</strong></p>
