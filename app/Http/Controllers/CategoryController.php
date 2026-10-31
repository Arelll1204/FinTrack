<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        abort_unless($category->user_id === Auth::id(), 403);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        abort_unless($category->user_id === Auth::id(), 403);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_unless($category->user_id === Auth::id(), 403);

        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        abort_unless($category->user_id === Auth::id(), 403);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
