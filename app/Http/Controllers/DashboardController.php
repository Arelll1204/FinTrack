<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\MonthlyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $now = Carbon::now();

        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        // Total saldo seluruh dompet
        $totalBalance = Wallet::where('user_id', $userId)
            ->sum('balance');

        // Total pemasukan keseluruhan
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        // Total pengeluaran keseluruhan
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        // Total budget keseluruhan
        $totalBudget = Budget::where('user_id', $userId)
            ->sum('amount');

        // Anggaran (Budget) bulan ini
        $monthlyBudgets = Budget::where('user_id', $userId)
            ->whereYear('start_date', $now->year)
            ->whereMonth('start_date', $now->month)
            ->with('category')
            ->get();

        $monthlyBudgetTotal = (float) $monthlyBudgets->sum('amount');

        // Pengeluaran aktual pada kategori yang dianggarkan di bulan ini
        $budgetCategoryIds = $monthlyBudgets->pluck('category_id')->unique();
        $monthlyBudgetSpent = (float) Transaction::where('user_id', $userId)
            ->whereIn('category_id', $budgetCategoryIds)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyBudgetRemaining = max(0, $monthlyBudgetTotal - $monthlyBudgetSpent);
        $monthlyBudgetOver = $monthlyBudgetSpent > $monthlyBudgetTotal ? ($monthlyBudgetSpent - $monthlyBudgetTotal) : 0;
        $monthlyBudgetPercentage = $monthlyBudgetTotal > 0 ? round(($monthlyBudgetSpent / $monthlyBudgetTotal) * 100, 1) : 0;

        // Pemasukan bulan ini
        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [
                $startOfMonth,
                $endOfMonth,
            ])
            ->sum('amount');

        // Pengeluaran bulan ini
        $monthlyExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [
                $startOfMonth,
                $endOfMonth,
            ])
            ->sum('amount');

        // Monthly Plans bulan ini
        $monthlyPlans = MonthlyPlan::where('user_id', $userId)
            ->where('month', $now->month)
            ->where('year', $now->year)
            ->with('category')
            ->get();

        $monthlyPlanTotal = $monthlyPlans->sum('amount');

        // Transaksi terbaru
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['category', 'wallet'])
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Data grafik 12 bulan (Januari - Desember) dengan filter tahun
        $currentYear = $now->year;
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $currentMonthName = $monthNames[$now->month] ?? $now->translatedFormat('F');

        // Mengambil daftar tahun yang tersedia dari transaksi dan perencanaan user
        $transactionYears = Transaction::where('user_id', $userId)
            ->whereNotNull('transaction_date')
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $planYears = MonthlyPlan::where('user_id', $userId)
            ->whereNotNull('year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $availableYears = array_values(array_unique(array_merge($transactionYears, $planYears, [$currentYear])));
        rsort($availableYears);

        // Tentukan tahun yang dipilih (default: tahun berjalan)
        $selectedYear = (int) $request->input('year', $currentYear);
        if (!in_array($selectedYear, $availableYears)) {
            $selectedYear = $currentYear;
        }

        // Query agregasi transaksi untuk tahun yang dipilih (tanpa query dalam loop)
        $monthlyTotals = Transaction::where('user_id', $userId)
            ->whereYear('transaction_date', $selectedYear)
            ->selectRaw('MONTH(transaction_date) as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->get();

        // Query agregasi anggaran monthly_plans untuk tahun yang dipilih (tanpa query dalam loop)
        $monthlyPlanTotals = MonthlyPlan::where('user_id', $userId)
            ->where('year', $selectedYear)
            ->selectRaw('month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartLabels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $chartIncome = array_fill(0, 12, 0);
        $chartExpense = array_fill(0, 12, 0);
        $chartPlan = array_fill(0, 12, 0);

        foreach ($monthlyTotals as $row) {
            $monthIndex = (int) $row->month - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                if ($row->type === 'income') {
                    $chartIncome[$monthIndex] = (float) $row->total;
                } elseif ($row->type === 'expense') {
                    $chartExpense[$monthIndex] = (float) $row->total;
                }
            }
        }

        foreach ($monthlyPlanTotals as $m => $total) {
            $mIndex = (int) $m - 1;
            if ($mIndex >= 0 && $mIndex < 12) {
                $chartPlan[$mIndex] = (float) $total;
            }
        }

        $chartIncome = array_values($chartIncome);
        $chartExpense = array_values($chartExpense);
        $chartPlan = array_values($chartPlan);

        return view('dashboard', compact(
            'totalBalance',
            'totalIncome',
            'totalExpense',
            'totalBudget',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyPlans',
            'monthlyPlanTotal',
            'recentTransactions',
            'chartLabels',
            'chartIncome',
            'chartExpense',
            'chartPlan',
            'currentYear',
            'currentMonthName',
            'selectedYear',
            'availableYears',
            'monthlyBudgets',
            'monthlyBudgetTotal',
            'monthlyBudgetSpent',
            'monthlyBudgetRemaining',
            'monthlyBudgetOver',
            'monthlyBudgetPercentage'
        ));
    }
}
