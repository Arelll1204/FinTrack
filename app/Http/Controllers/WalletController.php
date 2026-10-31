<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'balance' => 'required|numeric|min:0',
        ]);

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Dompet berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        abort_unless($wallet->user_id === Auth::id(), 403);

        return view('wallets.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        abort_unless($wallet->user_id === Auth::id(), 403);

        return view('wallets.edit', compact('wallet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        abort_unless($wallet->user_id === Auth::id(), 403);

        $request->validate([
            'name' => 'required|string|max:100',
            'balance' => 'required|numeric|min:0',
        ]);

        $wallet->update([
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Dompet berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        abort_unless($wallet->user_id === Auth::id(), 403);

        $wallet->delete();

        return redirect()
            ->route('wallets.index')
            ->with('success', 'Dompet berhasil dihapus.');
    }
}
