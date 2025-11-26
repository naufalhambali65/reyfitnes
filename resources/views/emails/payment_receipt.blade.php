<div style="font-family: Arial, sans-serif; color:#333; line-height:1.6;">
    <h2 style="text-align:center; margin-bottom: 20px;">🧾 Bukti Pembayaran</h2>

    <p>Halo <strong>{{ $payment->user->name }}</strong>,</p>
    <p>Terima kasih telah melakukan pembayaran. Berikut adalah detail transaksi Anda:</p>

    <table cellpadding="8" cellspacing="0" style="width:100%; background:#f7f7f7; border-radius:8px;">
        <tr>
            <td style="width:30%; font-weight:bold;">ID Pembayaran</td>
            <td>#{{ $payment->id }}</td>
        </tr>

        <tr>
            <td style="font-weight:bold;">Tanggal</td>
            <td>{{ $payment->created_at->translatedFormat('d F Y, H:i') }}</td>
        </tr>

        <tr>
            <td style="font-weight:bold;">Jumlah</td>
            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>

        <tr>
            <td style="font-weight:bold;">Metode</td>
            <td style="text-transform: uppercase;">
                {{ $payment->payment_method }}
            </td>
        </tr>

        <tr>
            <td style="font-weight:bold;">Status</td>
            <td>
                @if ($payment->status == 'completed')
                    <span style="color:green; font-weight:bold;">Selesai</span>
                @elseif ($payment->status == 'pending')
                    <span style="color:#e6a400; font-weight:bold;">Tertunda</span>
                @else
                    <span style="color:red; font-weight:bold;">Gagal</span>
                @endif
            </td>
        </tr>
    </table>

    <br>

    <p style="margin-top:20px;">
        Jika Anda membutuhkan bantuan, silakan hubungi admin kami.
    </p>

    <p>Terima kasih,<br><strong>Rey Fitness</strong></p>
</div>
