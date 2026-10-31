<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');

        $query = Transaction::where('user_id', Auth::id())
            ->with(['category', 'wallet']);

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        if ($type && in_array($type, ['income', 'expense'])) {
            $query->where('type', $type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'startDate', 'endDate', 'type'));
    }

    /**
     * Ekspor data transaksi ke file Excel (.xls).
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');

        $query = Transaction::where('user_id', Auth::id())
            ->with(['category', 'wallet']);

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        if ($type && in_array($type, ['income', 'expense'])) {
            $query->where('type', $type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $user = Auth::user();
        $filename = 'transaksi-fintrack-' . date('Ymd-His') . '.xls';

        return response()->streamDownload(function () use ($transactions, $user, $startDate, $endDate, $type) {
            echo view('transactions.excel', compact('transactions', 'user', 'startDate', 'endDate', 'type'))->render();
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        $wallets = Wallet::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('categories', 'wallets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|gt:0',
            'transaction_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'description' => 'required|string|max:255',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$category) {
            return back()->withInput()->withErrors(['category_id' => 'Kategori tidak valid atau bukan milik Anda.']);
        }

        $wallet = Wallet::where('id', $validated['wallet_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$wallet) {
            return back()->withInput()->withErrors(['wallet_id' => 'Dompet tidak valid atau bukan milik Anda.']);
        }

        DB::transaction(function () use ($validated, $wallet) {
            Transaction::create([
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'wallet_id' => $validated['wallet_id'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'transaction_date' => $validated['transaction_date'],
            ]);

            // Update saldo dompet otomatis
            if ($validated['type'] === 'income') {
                $wallet->increment('balance', $validated['amount']);
            } else {
                $wallet->decrement('balance', $validated['amount']);
            }
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        abort_unless($transaction->user_id === Auth::id(), 403);

        $transaction->load(['category', 'wallet']);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        abort_unless($transaction->user_id === Auth::id(), 403);

        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        $wallets = Wallet::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.edit', compact('transaction', 'categories', 'wallets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        abort_unless($transaction->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|gt:0',
            'transaction_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'description' => 'required|string|max:255',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$category) {
            return back()->withInput()->withErrors(['category_id' => 'Kategori tidak valid atau bukan milik Anda.']);
        }

        $newWallet = Wallet::where('id', $validated['wallet_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$newWallet) {
            return back()->withInput()->withErrors(['wallet_id' => 'Dompet tidak valid atau bukan milik Anda.']);
        }

        DB::transaction(function () use ($transaction, $validated, $newWallet) {
            // Revert dampak saldo dari transaksi lama
            $oldWallet = Wallet::find($transaction->wallet_id);
            if ($oldWallet) {
                if ($transaction->type === 'income') {
                    $oldWallet->decrement('balance', $transaction->amount);
                } else {
                    $oldWallet->increment('balance', $transaction->amount);
                }
            }

            // Apply dampak saldo ke dompet baru
            $targetWallet = ($oldWallet && $oldWallet->id === $newWallet->id) ? $oldWallet->fresh() : $newWallet;

            if ($validated['type'] === 'income') {
                $targetWallet->increment('balance', $validated['amount']);
            } else {
                $targetWallet->decrement('balance', $validated['amount']);
            }

            // Update transaksi
            $transaction->update([
                'category_id' => $validated['category_id'],
                'wallet_id' => $validated['wallet_id'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'transaction_date' => $validated['transaction_date'],
            ]);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        abort_unless($transaction->user_id === Auth::id(), 403);

        DB::transaction(function () use ($transaction) {
            // Revert dampak saldo dompet
            $wallet = Wallet::find($transaction->wallet_id);
            if ($wallet) {
                if ($transaction->type === 'income') {
                    $wallet->decrement('balance', $transaction->amount);
                } else {
                    $wallet->increment('balance', $transaction->amount);
                }
            }

            $transaction->delete();
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
