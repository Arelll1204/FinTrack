<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Keuangan</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        body { font-family: Calibri, Arial, sans-serif; }
        .main-title { font-size: 16pt; font-weight: bold; color: #1e1b4b; }
        .subtitle { font-size: 11pt; color: #4b5563; }
        .section-header {
            font-size: 13pt;
            font-weight: bold;
            color: #1e1b4b;
            background-color: #e0e7ff;
            padding: 6px;
        }
        th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 0.5pt solid #3730a3;
            padding: 6px 10px;
        }
        td {
            border: 0.5pt solid #d1d5db;
            padding: 5px 8px;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .income { color: #16a34a; font-weight: bold; }
        .expense { color: #dc2626; font-weight: bold; }
        .number-fmt { mso-number-format: "\#\,\#\#0"; }
        .date-fmt { mso-number-format: "yyyy-mm-dd"; text-align: center; }
        .metric-title { background-color: #f9fafb; font-weight: bold; }
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
            border-top: 1.5pt solid #4f46e5;
        }
    </style>
</head>
<body>
    <table>
        <!-- Header Dokumen -->
        <tr>
            <td colspan="6" class="main-title">LAPORAN KEUANGAN BULANAN — FINTRACK</td>
        </tr>
        <tr>
            <td colspan="6" class="subtitle">
                Periode: {{ $selectedMonthName }} {{ $selectedYear }} | Pengguna: {{ $user->name }} ({{ $user->email }})
            </td>
        </tr>
        <tr>
            <td colspan="6" style="color: #6b7280; font-size: 10pt;">
                Tanggal Ekspor: {{ date('d/m/Y H:i') }}
            </td>
        </tr>
        <tr><td colspan="6"></td></tr>

        <!-- Ringkasan Arus Kas -->
        <tr>
            <td colspan="6" class="section-header">1. RINGKASAN ARUS KAS</td>
        </tr>
        <tr>
            <th colspan="3">Indikator</th>
            <th colspan="3">Nominal (Rp)</th>
        </tr>
        <tr>
            <td colspan="3" class="metric-title">Total Pemasukan:</td>
            <td colspan="3" class="text-right number-fmt income">{{ $totalIncome }}</td>
        </tr>
        <tr>
            <td colspan="3" class="metric-title">Total Pengeluaran:</td>
            <td colspan="3" class="text-right number-fmt expense">{{ $totalExpense }}</td>
        </tr>
        <tr class="total-row">
            <td colspan="3" class="metric-title">Selisih (Arus Kas Bersih):</td>
            <td colspan="3" class="text-right number-fmt {{ $netCashflow >= 0 ? 'income' : 'expense' }}">
                {{ $netCashflow }}
            </td>
        </tr>
        <tr>
            <td colspan="3" class="metric-title">Total Mutasi Transaksi:</td>
            <td colspan="3" class="text-right font-bold">{{ $totalTransactionsCount }} Transaksi</td>
        </tr>

        <tr><td colspan="6"></td></tr>

        <!-- Rincian Pengeluaran Berdasarkan Kategori -->
        <tr>
            <td colspan="6" class="section-header">2. RINCIAN PENGELUARAN BERDASARKAN KATEGORI</td>
        </tr>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th colspan="2" style="width: 250px;">Kategori</th>
                <th style="width: 120px;">Jumlah Transaksi</th>
                <th style="width: 160px;">Total Pengeluaran (Rp)</th>
                <th style="width: 100px;">Proporsi (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categoryExpenses as $idx => $cat)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td colspan="2"><strong>{{ $cat->category_name }}</strong></td>
                    <td class="text-center">{{ $cat->count }} kali</td>
                    <td class="text-right number-fmt expense">{{ $cat->total_amount }}</td>
                    <td class="text-right font-semibold">{{ $cat->percentage }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #6b7280;">
                        Tidak ada pengeluaran pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tr><td colspan="6"></td></tr>

        <!-- Daftar Seluruh Transaksi Periode Ini -->
        <tr>
            <td colspan="6" class="section-header">3. DAFTAR SELURUH TRANSAKSI</td>
        </tr>
        <thead>
            <tr>
                <th style="width: 90px;">Tanggal</th>
                <th style="width: 260px;">Keterangan / Deskripsi</th>
                <th style="width: 140px;">Kategori</th>
                <th style="width: 120px;">Dompet</th>
                <th style="width: 100px;">Tipe</th>
                <th style="width: 150px;">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $t)
                <tr>
                    <td class="date-fmt">{{ $t->transaction_date ? $t->transaction_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ $t->description }}</td>
                    <td>{{ $t->category->name ?? '-' }}</td>
                    <td>{{ $t->wallet->name ?? '-' }}</td>
                    <td class="text-center {{ $t->type === 'income' ? 'income' : 'expense' }}">
                        {{ $t->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </td>
                    <td class="text-right number-fmt {{ $t->type === 'income' ? 'income' : 'expense' }}">
                        {{ $t->amount }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #6b7280;">
                        Belum ada mutasi transaksi pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

