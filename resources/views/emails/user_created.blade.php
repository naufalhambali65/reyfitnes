<h2>Akun Anda Telah Dibuat</h2>

<p>Halo {{ $user->name }},</p>

<p>Berikut detail akun Anda:</p>

<ul>
    <li><strong>Email:</strong> {{ $user->email }}</li>
    <li><strong>Password:</strong> {{ $rawPassword }}</li>
</ul>

<p>Silakan login menggunakan detail di atas.</p>

<p>Terima kasih,<br>Rey Fitness</p>
