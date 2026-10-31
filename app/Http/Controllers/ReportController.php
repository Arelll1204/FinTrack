<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected array $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    /**
     * Tampilkan halaman laporan keuangan bulanan.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $now = Carbon::now();

        $selectedMonth = (int) $request->input('month', $now->month);
        $selectedYear = (int) $request->input('year', $now->year);

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = $now->month;
        }

        // Ambil daftar tahun dari transaksi user
        $transactionYears = Transaction::where('user_id', $userId)
            ->whereNotNull('transaction_date')
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $availableYears = array_values(array_unique(array_merge($transactionYears, [$now->year])));
        rsort($availableYears);

        // Rentang tanggal bulan terpilih
        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth()->toDateString();

        // 1. Total Pemasukan & Pengeluaran
        $totalIncome = (float) Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = (float) Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        // 2. Selisih (Arus Kas Bersih)
        $netCashflow = $totalIncome - $totalExpense;

        // 3. Jumlah Transaksi
        $totalTransactionsCount = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->count();

        $incomeCount = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->count();

        $expenseCount = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->count();

        // 4. Pengeluaran Berdasarkan Kategori
        $categoryExpenses = Transaction::where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(transactions.amount) as total_amount, COUNT(transactions.id) as count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        foreach ($categoryExpenses as $item) {
            $item->total_amount = (float) $item->total_amount;
            $item->percentage = $totalExpense > 0 ? round(($item->total_amount / $totalExpense) * 100, 1) : 0;
        }

        // 5. Pemasukan Berdasarkan Kategori
        $categoryIncomes = Transaction::where('transactions.user_id', $userId)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(transactions.amount) as total_amount, COUNT(transactions.id) as count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        foreach ($categoryIncomes as $item) {
            $item->total_amount = (float) $item->total_amount;
            $item->percentage = $totalIncome > 0 ? round(($item->total_amount / $totalIncome) * 100, 1) : 0;
        }

        // 6. Daftar Transaksi pada Periode Terpilih
        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['category', 'wallet'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // 7. Data untuk Chart.js
        $chartComparisonLabels = ['Pemasukan', 'Pengeluaran'];
        $chartComparisonData = [$totalIncome, $totalExpense];

        $chartCategoryLabels = $categoryExpenses->pluck('category_name')->toArray();
        $chartCategoryData = $categoryExpenses->pluck('total_amount')->toArray();

        $monthNames = $this->monthNames;
        $selectedMonthName = $monthNames[$selectedMonth] ?? 'Bulan ' . $selectedMonth;

        return view('reports.index', compact(
            'selectedMonth',
            'selectedYear',
            'selectedMonthName',
            'availableYears',
            'monthNames',
            'totalIncome',
            'totalExpense',
            'netCashflow',
            'totalTransactionsCount',
            'incomeCount',
            'expenseCount',
            'categoryExpenses',
            'categoryIncomes',
            'transactions',
            'chartComparisonLabels',
            'chartComparisonData',
            'chartCategoryLabels',
            'chartCategoryData'
        ));
    }

    /**
     * Tampilan cetak / simpan PDF laporan keuangan.
     */
    public function print(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $now = Carbon::now();

        $selectedMonth = (int) $request->input('month', $now->month);
        $selectedYear = (int) $request->input('year', $now->year);

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = $now->month;
        }

        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth()->toDateString();

        $totalIncome = (float) Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = (float) Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $netCashflow = $totalIncome - $totalExpense;

        $totalTransactionsCount = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->count();

        $categoryExpenses = Transaction::where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(transactions.amount) as total_amount, COUNT(transactions.id) as count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        foreach ($categoryExpenses as $item) {
            $item->total_amount = (float) $item->total_amount;
            $item->percentage = $totalExpense > 0 ? round(($item->total_amount / $totalExpense) * 100, 1) : 0;
        }

        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['category', 'wallet'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $selectedMonthName = $this->monthNames[$selectedMonth] ?? 'Bulan ' . $selectedMonth;

        return view('reports.print', compact(
            'user',
            'selectedMonth',
            'selectedYear',
            'selectedMonthName',
            'totalIncome',
            'totalExpense',
            'netCashflow',
            'totalTransactionsCount',
            'categoryExpenses',
            'transactions'
        ));
    }

    /**
     * Ekspor Laporan Keuangan ke format Excel (.xls).
     */
    public function export(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $now = Carbon::now();

        $selectedMonth = (int) $request->input('month', $now->month);
        $selectedYear = (int) $request->input('year', $now->year);

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = $now->month;
        }

        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth()->toDateString();

        $totalIncome = (float) Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = (float) Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $netCashflow = $totalIncome - $totalExpense;

        $totalTransactionsCount = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->count();

        $categoryExpenses = Transaction::where('transactions.user_id', $userId)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(transactions.amount) as total_amount, COUNT(transactions.id) as count')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_amount', 'desc')
            ->get();

        foreach ($categoryExpenses as $item) {
            $item->total_amount = (float) $item->total_amount;
            $item->percentage = $totalExpense > 0 ? round(($item->total_amount / $totalExpense) * 100, 1) : 0;
        }

        $transactions = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['category', 'wallet'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $selectedMonthName = $this->monthNames[$selectedMonth] ?? 'Bulan ' . $selectedMonth;

        $filename = 'laporan-keuangan-' . strtolower($selectedMonthName) . '-' . $selectedYear . '.xls';

        return response()->streamDownload(function () use (
            $user,
            $selectedMonth,
            $selectedYear,
            $selectedMonthName,
            $totalIncome,
            $totalExpense,
            $netCashflow,
            $totalTransactionsCount,
            $categoryExpenses,
            $transactions
        ) {
            echo view('reports.excel', compact(
                'user',
                'selectedMonth',
                'selectedYear',
                'selectedMonthName',
                'totalIncome',
                'totalExpense',
                'netCashflow',
                'totalTransactionsCount',
                'categoryExpenses',
                'transactions'
            ))->render();
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}

