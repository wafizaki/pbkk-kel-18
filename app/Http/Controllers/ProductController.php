<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // If there is a search query, filter the products
        if ($query) {
            $products = Product::where('name', 'LIKE', "%{$query}%")
                                ->orWhere('description', 'LIKE', "%{$query}%")
                                ->get();
        } else {
            // If no query, return all products (or return an empty collection if you don't want to show any products)
            $products = Product::all();
        }

        return view('products.index', compact('products', 'query'));
    }

    public function addView(){
        return view('products.add');
    }

    public function addStore(Request $request):RedirectResponse{
        
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_url' => 'https://picsum.photos/id/'.$request->image_url.'/200/300',
            'price' => $request->price,
        ]);
        return redirect(route('shop.index'));
    }


}

