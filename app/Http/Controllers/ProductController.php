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
public function editView()
{
    // Ambil semua produk untuk diedit
    $products = Product::all();

    // Tampilkan halaman edit dengan produk yang ada
    return view('products.edit', compact('products'));
}

public function edit($id)
{
    // Retrieve the product by its ID
    $product = Product::findOrFail($id);

    // Return the edit view with the product data
    return view('products.edit-form', compact('product'));
}

public function update(Request $request, $id): RedirectResponse
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image
        'price' => 'required|numeric|min:0',
    ]);

    // Retrieve the product by its ID
    $product = Product::findOrFail($id);

    // Update the product details
    $product->name = $request->name;
    $product->category = $request->category;
    $product->price = $request->price;

    // If a new image is uploaded, store it and update the image_url
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        Storage::disk('public')->delete($product->image_url);

        // Store the new image
        $imagePath = $request->file('image')->store('images', 'public');
        $product->image_url = $imagePath;
    }

    // Save the changes
    $product->save();

    return redirect()->route('shop.index')->with('success', 'Product updated successfully!');
}
public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('shop.index')->with('success', 'Product deleted successfully.');
}


}
