<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Transaksi FinTrack</x:Name>
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
        .title { font-size: 16pt; font-weight: bold; color: #1e1b4b; }
        .subtitle { font-size: 11pt; color: #4b5563; }
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
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
            border-top: 1.5pt solid #4f46e5;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="7" class="title">LAPORAN MUTASI TRANSAKSI — FINTRACK</td>
        </tr>
        <tr>
            <td colspan="7" class="subtitle">
                Pengguna: {{ $user->name }} ({{ $user->email }}) | Diekspor pada: {{ date('d/m/Y H:i') }}
            </td>
        </tr>
        @if ($startDate || $endDate || $type)
            <tr>
                <td colspan="7" style="color: #6b7280; font-size: 10pt;">
                    Filter:
                    @if ($startDate) Dari: {{ $startDate }} @endif
                    @if ($endDate) Sampai: {{ $endDate }} @endif
                    @if ($type) Tipe: {{ ucfirst($type) }} @endif
                </td>
            </tr>
        @endif
        <tr><td colspan="7"></td></tr>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 100px;">Tanggal</th>
                <th style="width: 250px;">Deskripsi / Keterangan</th>
                <th style="width: 150px;">Kategori</th>
                <th style="width: 130px;">Dompet</th>
                <th style="width: 110px;">Tipe</th>
                <th style="width: 140px;">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumIncome = 0;
                $sumExpense = 0;
            @endphp
            @forelse ($transactions as $index => $t)
                @php
                    if ($t->type === 'income') {
                        $sumIncome += $t->amount;
                    } else {
                        $sumExpense += $t->amount;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
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
                    <td colspan="7" class="text-center" style="padding: 16px; color: #6b7280;">
                        Tidak ada data transaksi yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($transactions->isNotEmpty())
            <tfoot>
                <tr class="total-row">
                    <td colspan="6" class="text-right">Total Pemasukan:</td>
                    <td class="text-right number-fmt income">{{ $sumIncome }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" class="text-right">Total Pengeluaran:</td>
                    <td class="text-right number-fmt expense">{{ $sumExpense }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" class="text-right">Selisih (Arus Kas Bersih):</td>
                    <td class="text-right number-fmt {{ ($sumIncome - $sumExpense) >= 0 ? 'income' : 'expense' }}">
                        {{ $sumIncome - $sumExpense }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>
</html>

