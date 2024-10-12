<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');

        // Query for products
        $products = Product::query();

        // Apply search query if provided
        if ($query) {
            $products->where('name', 'LIKE', "%{$query}%")
                     ->orWhere('category', 'LIKE', "%{$query}%");
        }

        // Apply category filter if provided
        if ($category) {
            $products->where('category', $category);
        }

        // Get the results
        $products = $products->get();

        return view('products.index', compact('products', 'query', 'category'));
    }

    public function search(Request $request)
    {
        return $this->index($request); // Redirect to the index method with the same request
    }

    public function addView()
    {
        return view('products.add');
    }

    public function addStore(Request $request): RedirectResponse
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        'price' => 'required|numeric|min:0',
    ]);

    // Menyimpan gambar
    $imagePath = $request->file('image')->store('images', 'public'); // Simpan gambar ke storage

    // Membuat produk baru
    Product::create([
        'name' => $request->name,
        'category' => $request->category, // Kategori diambil dari input teks
        'image_url' => $imagePath, // Mendapatkan URL untuk gambar yang disimpan
        'price' => $request->price,
    ]);

    return redirect()->route('shop.index')->with('success', 'Product added successfully!'); // Menambahkan pesan sukses
}

}
