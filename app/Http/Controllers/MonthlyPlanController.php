<?php

namespace App\Http\Controllers;

use App\Models\MonthlyPlan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyPlanController extends Controller
{
    public function index()
    {
        $plans = MonthlyPlan::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('monthly-plans.index', compact('plans'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('monthly-plans.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->first();

        if (!$category) {
            return back()
                ->withErrors(['category_id' => 'Kategori tidak valid.'])
                ->withInput();
        }

        MonthlyPlan::create([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
            'name' => $validated['name'],
            'amount' => $validated['amount'],
            'month' => $validated['month'],
            'year' => $validated['year'],
        ]);

        return redirect()
            ->route('monthly-plans.index')
            ->with('success', 'Rencana bulanan berhasil ditambahkan.');
    }

    public function show(MonthlyPlan $monthlyPlan)
    {
        abort_unless(
            $monthlyPlan->user_id === Auth::id(),
            403
        );

        $monthlyPlan->load('category');

        return view('monthly-plans.show', compact('monthlyPlan'));
    }

    public function edit(MonthlyPlan $monthlyPlan)
    {
        abort_unless(
            $monthlyPlan->user_id === Auth::id(),
            403
        );

        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view(
            'monthly-plans.edit',
            compact('monthlyPlan', 'categories')
        );
    }

    public function update(Request $request, MonthlyPlan $monthlyPlan)
    {
        abort_unless(
            $monthlyPlan->user_id === Auth::id(),
            403
        );

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->first();

        if (!$category) {
            return back()
                ->withErrors(['category_id' => 'Kategori tidak valid.'])
                ->withInput();
        }

        $monthlyPlan->update([
            'category_id' => $category->id,
            'name' => $validated['name'],
            'amount' => $validated['amount'],
            'month' => $validated['month'],
            'year' => $validated['year'],
        ]);

        return redirect()
            ->route('monthly-plans.index')
            ->with('success', 'Rencana bulanan berhasil diperbarui.');
    }

    public function destroy(MonthlyPlan $monthlyPlan)
    {
        abort_unless(
            $monthlyPlan->user_id === Auth::id(),
            403
        );

        $monthlyPlan->delete();

        return redirect()
            ->route('monthly-plans.index')
            ->with('success', 'Rencana bulanan berhasil dihapus.');
    }
}