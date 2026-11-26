<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('master-data.category.index', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('master-data.category.create');
    }

    // Menyimpan kategori baru
public function store(StoreCategoryRequest $request)
{
    Category::create($request->validated());

    return redirect()
        ->route('categories.index')
        ->with('success', 'Kategori berhasil ditambahkan.');
}

    // Menampilkan detail kategori
    public function show(Category $category)
    {
        //
    }

    // Menampilkan form edit kategori
    public function edit(Category $category)
    {
        //
    }

    // Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        //
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        //
    }

    public function productCount()
{
    $categories = Category::withCount('products')
        ->orderBy('name')
        ->get();

    return view(
        'master-data.category.product-count',
        compact('categories')
    );
}
}
