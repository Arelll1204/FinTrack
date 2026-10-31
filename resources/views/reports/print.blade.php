<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan {{ $selectedMonthName }} {{ $selectedYear }} - FinTrack</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            margin: 0;
            padding: 24px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .no-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #4338ca;
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #374151;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1e1b4b;
        }

        .header p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 32px;
        }

        .metric-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            background: #fdfdfd;
        }

        .metric-label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
        }

        .metric-value {
            font-size: 18px;
            font-weight: 700;
            margin-top: 6px;
        }

        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-indigo { color: #4f46e5; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 32px;
        }

        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: 600;
            text-align: left;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
        }

        td {
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1f2937;
            border-left: 4px solid #4f46e5;
            padding-left: 8px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #9ca3af;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Tombol Cetak (Hanya tampil di browser) -->
    <div class="no-print">
        <div>
            <strong>Mode Cetak Laporan</strong> — Klik tombol di samping untuk mencetak atau menyimpan dokumen sebagai file PDF.
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn btn-primary">
                &#128424; Cetak / Simpan PDF
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                Tutup
            </button>
        </div>
    </div>

    <!-- Header Dokumen -->
    <div class="header">
        <div>
            <h1>FinTrack — Laporan Keuangan Bulanan</h1>
            <p>Aplikasi Manajemen Keuangan Pribadi</p>
        </div>
        <div class="text-right">
            <h2 style="margin: 0; font-size: 18px; color: #4f46e5;">Periode: {{ $selectedMonthName }} {{ $selectedYear }}</h2>
            <p style="margin: 4px 0 0; font-size: 12px; color: #6b7280;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Metadata Pengguna -->
    <div class="info-grid">
        <div>
            <strong>Nama Pengguna:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}
        </div>
        <div class="text-right">
            <strong>Total Mutasi:</strong> {{ $totalTransactionsCount }} Transaksi<br>
            <strong>Status Arus Kas:</strong> {{ $netCashflow >= 0 ? 'Surplus' : 'Defisit' }}
        </div>
    </div>

    <!-- Ringkasan Angka -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Total Pemasukan</div>
            <div class="metric-value text-green">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Total Pengeluaran</div>
            <div class="metric-value text-red">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Arus Kas Bersih</div>
            <div class="metric-value {{ $netCashflow >= 0 ? 'text-indigo' : 'text-red' }}">
                {{ $netCashflow >= 0 ? '+' : '' }} Rp {{ number_format($netCashflow, 0, ',', '.') }}
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Total Transaksi</div>
            <div class="metric-value">
                {{ $totalTransactionsCount }}
            </div>
        </div>
    </div>

    <!-- Rincian Pengeluaran Berdasarkan Kategori -->
    <div class="section-title">Rincian Pengeluaran Berdasarkan Kategori</div>
    <table>
        <thead>
            <tr>
                <th style="width: 50px;" class="text-center">No</th>
                <th>Kategori</th>
                <th class="text-center" style="width: 120px;">Jumlah Transaksi</th>
                <th class="text-right" style="width: 180px;">Total Pengeluaran</th>
                <th class="text-right" style="width: 100px;">Proporsi (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categoryExpenses as $index => $cat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $cat->category_name }}</strong></td>
                    <td class="text-center">{{ $cat->count }} kali</td>
                    <td class="text-right text-red font-semibold">
                        Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="text-right font-semibold">{{ $cat->percentage }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 16px; color: #6b7280;">
                        Tidak ada pengeluaran pada periode {{ $selectedMonthName }} {{ $selectedYear }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Daftar Transaksi Lengkap -->
    <div class="section-title">Daftar Transaksi Lengkap</div>
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">Tanggal</th>
                <th>Keterangan / Deskripsi</th>
                <th style="width: 130px;">Kategori</th>
                <th style="width: 120px;">Dompet</th>
                <th style="width: 90px;" class="text-center">Tipe</th>
                <th style="width: 140px;" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $t)
                <tr>
                    <td>{{ $t->transaction_date ? $t->transaction_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ $t->category->name ?? '-' }}</td>
                    <td>{{ $t->wallet->name ?? '-' }}</td>
                    <td class="text-center">
                        <span style="font-size: 11px; font-weight: 600; color: {{ $t->type === 'income' ? '#16a34a' : '#dc2626' }};">
                            {{ $t->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="text-right {{ $t->type === 'income' ? 'text-green' : 'text-red' }}" style="font-weight: 600;">
                        {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 16px; color: #6b7280;">
                        Belum ada mutasi transaksi yang tercatat pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>Dokumen ini dibuat otomatis oleh FinTrack Application.</div>
        <div>Halaman 1 dari 1</div>
    </div>

</div>

</body>
</html>

