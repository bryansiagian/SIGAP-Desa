<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #3D3226; }
        .header { text-align: center; border-bottom: 2px solid #3D3226; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; margin: 0; }
        .header p { font-size: 11px; margin: 2px 0; }
        .title { text-align: center; margin: 20px 0; }
        .title h2 { font-size: 14px; text-decoration: underline; margin: 0; }
        .title p { font-size: 11px; margin: 3px 0; }
        table.data { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table.data td { padding: 4px 0; vertical-align: top; }
        table.data td.label { width: 180px; }
        table.data td.colon { width: 15px; }
        .footer { margin-top: 40px; width: 100%; }
        .footer table { width: 100%; }
        .footer .qr { text-align: center; }
        .footer .qr img { width: 80px; height: 80px; }
        .footer .qr p { font-size: 9px; color: #666; margin-top: 4px; }
        .footer .ttd { text-align: center; }
        .footer .ttd p { margin: 2px 0; }
        .footer .ttd .space { height: 60px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH DESA</h1>
        <p>Layanan Administrasi Digital — SIGAP Desa</p>
    </div>

    <div class="title">
        <h2>{{ strtoupper($submission->serviceType->nama_layanan) }}</h2>
        <p>Nomor: {{ $submission->nomor_surat }}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini menerangkan bahwa data berikut telah diverifikasi dan disetujui:</p>

    <table class="data">
        @foreach ($submission->fields_snapshot as $field)
            @if ($field['field_type'] !== 'file')
                <tr>
                    <td class="label">{{ $field['label'] }}</td>
                    <td class="colon">:</td>
                    <td>{{ $submission->data[$field['field_key']] ?? '-' }}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td class="label">Diajukan oleh</td>
            <td class="colon">:</td>
            <td>{{ $submission->submitter->name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal disetujui</td>
            <td class="colon">:</td>
            <td>{{ $submission->updated_at->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <p>Surat ini diterbitkan secara elektronik melalui sistem SIGAP Desa dan sah tanpa memerlukan tanda tangan basah, dapat diverifikasi keasliannya melalui kode QR di bawah ini.</p>

    <div class="footer">
        <table>
            <tr>
                <td class="qr" style="width: 30%;">
                    {!! $qrSvg !!}
                    <p>Pindai untuk verifikasi</p>
                </td>
                <td class="ttd" style="width: 70%;">
                    <p>Ditetapkan secara elektronik</p>
                    <div class="space"></div>
                    <p><strong>Kepala Desa</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
