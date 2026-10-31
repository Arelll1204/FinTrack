<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetController extends Controller
{
    protected array $monthNames = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    /**
     * Display a listing of the resource.
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

        // Ambil daftar tahun dari data budget dan transaksi user
        $budgetYears = Budget::where('user_id', $userId)
            ->selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $transactionYears = Transaction::where('user_id', $userId)
            ->whereNotNull('transaction_date')
            ->selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->pluck('year')
            ->map(fn($y) => (int) $y)
            ->toArray();

        $availableYears = array_values(array_unique(array_merge($budgetYears, $transactionYears, [$now->year])));
        rsort($availableYears);

        // Ambil data budget user untuk bulan & tahun terpilih
        $budgets = Budget::where('user_id', $userId)
            ->whereYear('start_date', $selectedYear)
            ->whereMonth('start_date', $selectedMonth)
            ->with('category')
            ->get();

        // Periode bulan terpilih untuk query pengeluaran
        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth()->toDateString();

        // Query pengeluaran aktual dari transactions untuk kategori-kategori pada bulan & tahun ini
        $expensesByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('category_id, SUM(amount) as total_spent')
            ->groupBy('category_id')
            ->pluck('total_spent', 'category_id');

        // Hitung pemakaian, sisa, persentase, dan status untuk setiap budget
        foreach ($budgets as $budget) {
            $spent = (float) ($expensesByCategory[$budget->category_id] ?? 0);
            $budget->calculated_spent = $spent;
            $budget->remaining = $budget->amount - $spent;
            $budget->over_budget = max(0, $spent - $budget->amount);
            $budget->percentage = $budget->amount > 0 ? round(($spent / $budget->amount) * 100, 1) : 0;

            if ($budget->percentage > 100) {
                $budget->status = 'over';
                $budget->status_label = 'Melebihi Budget';
                $budget->status_badge = 'bg-red-100 text-red-800 border-red-200';
                $budget->progress_color = 'bg-red-600';
            } elseif ($budget->percentage >= 80) {
                $budget->status = 'warning';
                $budget->status_label = 'Hampir Habis';
                $budget->status_badge = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                $budget->progress_color = 'bg-yellow-500';
            } else {
                $budget->status = 'safe';
                $budget->status_label = 'Aman';
                $budget->status_badge = 'bg-green-100 text-green-800 border-green-200';
                $budget->progress_color = 'bg-green-600';
            }
        }

        // Ringkasan keseluruhan periode
        $totalBudget = $budgets->sum('amount');
        $totalSpent = $budgets->sum('calculated_spent');
        $totalRemaining = max(0, $totalBudget - $totalSpent);
        $totalOver = $totalSpent > $totalBudget ? ($totalSpent - $totalBudget) : 0;
        $totalPercentage = $totalBudget > 0 ? round(($totalSpent / $totalBudget) * 100, 1) : 0;

        $monthNames = $this->monthNames;
        $selectedMonthName = $monthNames[$selectedMonth] ?? 'Bulan ' . $selectedMonth;

        return view('budgets.index', compact(
            'budgets',
            'selectedMonth',
            'selectedYear',
            'selectedMonthName',
            'availableYears',
            'monthNames',
            'totalBudget',
            'totalSpent',
            'totalRemaining',
            'totalOver',
            'totalPercentage'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        $monthNames = $this->monthNames;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return view('budgets.create', compact('categories', 'monthNames', 'currentMonth', 'currentYear'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|gt:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->first();

        if (!$category) {
            return back()->withInput()->withErrors([
                'category_id' => 'Kategori harus berupa kategori pengeluaran milik Anda.'
            ]);
        }

        // Cek duplikasi budget untuk kategori, bulan, dan tahun yang sama
        $exists = Budget::where('user_id', Auth::id())
            ->where('category_id', $validated['category_id'])
            ->whereYear('start_date', $validated['year'])
            ->whereMonth('start_date', $validated['month'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'category_id' => 'Anggaran untuk kategori "' . $category->name . '" pada ' . ($this->monthNames[$validated['month']] ?? $validated['month']) . ' ' . $validated['year'] . ' sudah pernah dibuat.'
            ]);
        }

        $startDate = Carbon::create($validated['year'], $validated['month'], 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($validated['year'], $validated['month'], 1)->endOfMonth()->toDateString();

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'name' => 'Anggaran ' . $category->name . ' (' . ($this->monthNames[$validated['month']] ?? $validated['month']) . ' ' . $validated['year'] . ')',
            'amount' => $validated['amount'],
            'spent' => 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()
            ->route('budgets.index', ['month' => $validated['month'], 'year' => $validated['year']])
            ->with('success', 'Anggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        abort_unless($budget->user_id === Auth::id(), 403);

        $budget->load('category');

        $startDate = $budget->start_date ? $budget->start_date->copy()->startOfMonth()->toDateString() : null;
        $endDate = $budget->end_date ? $budget->end_date->copy()->endOfMonth()->toDateString() : null;

        // Ambil transaksi pengeluaran aktual yang terkait
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('category_id', $budget->category_id)
            ->where('type', 'expense')
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->with('wallet')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $spent = (float) $transactions->sum('amount');
        $budget->calculated_spent = $spent;
        $budget->remaining = $budget->amount - $spent;
        $budget->over_budget = max(0, $spent - $budget->amount);
        $budget->percentage = $budget->amount > 0 ? round(($spent / $budget->amount) * 100, 1) : 0;

        if ($budget->percentage > 100) {
            $budget->status_label = 'Melebihi Budget';
            $budget->status_badge = 'bg-red-100 text-red-800 border-red-200';
            $budget->progress_color = 'bg-red-600';
        } elseif ($budget->percentage >= 80) {
            $budget->status_label = 'Hampir Habis';
            $budget->status_badge = 'bg-yellow-100 text-yellow-800 border-yellow-200';
            $budget->progress_color = 'bg-yellow-500';
        } else {
            $budget->status_label = 'Aman';
            $budget->status_badge = 'bg-green-100 text-green-800 border-green-200';
            $budget->progress_color = 'bg-green-600';
        }

        $monthName = $this->monthNames[$budget->month] ?? 'Bulan ' . $budget->month;

        return view('budgets.show', compact('budget', 'transactions', 'monthName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        abort_unless($budget->user_id === Auth::id(), 403);

        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        $monthNames = $this->monthNames;

        return view('budgets.edit', compact('budget', 'categories', 'monthNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        abort_unless($budget->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|gt:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->first();

        if (!$category) {
            return back()->withInput()->withErrors([
                'category_id' => 'Kategori harus berupa kategori pengeluaran milik Anda.'
            ]);
        }

        // Cek duplikasi mengecualikan data budget saat ini
        $exists = Budget::where('user_id', Auth::id())
            ->where('category_id', $validated['category_id'])
            ->whereYear('start_date', $validated['year'])
            ->whereMonth('start_date', $validated['month'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'category_id' => 'Anggaran untuk kategori "' . $category->name . '" pada ' . ($this->monthNames[$validated['month']] ?? $validated['month']) . ' ' . $validated['year'] . ' sudah pernah dibuat.'
            ]);
        }

        $startDate = Carbon::create($validated['year'], $validated['month'], 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($validated['year'], $validated['month'], 1)->endOfMonth()->toDateString();

        $budget->update([
            'category_id' => $validated['category_id'],
            'name' => 'Anggaran ' . $category->name . ' (' . ($this->monthNames[$validated['month']] ?? $validated['month']) . ' ' . $validated['year'] . ')',
            'amount' => $validated['amount'],
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()
            ->route('budgets.index', ['month' => $validated['month'], 'year' => $validated['year']])
            ->with('success', 'Anggaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        abort_unless($budget->user_id === Auth::id(), 403);

        $month = $budget->month;
        $year = $budget->year;

        $budget->delete();

        return redirect()
            ->route('budgets.index', ['month' => $month, 'year' => $year])
            ->with('success', 'Anggaran berhasil dihapus.');
    }
}

