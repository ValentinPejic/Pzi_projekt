<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Prikazuje sve proizvode
    public function index()
    {
        $products = Product::all();
        return view('home', compact('products'));
    }

    // Prikazuje formu za kreiranje novog proizvoda
    public function create()
    {
        return view('create-product');
    }

    // Sprema novi proizvod u bazu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
    
        if ($request->hasFile('image')) {
            // Pohranjuje sliku u 'public/images' i sprema relativnu putanju u bazu
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }
    
        $product->save();
    
        return redirect()->route('products.index')->with('success', 'Proizvod je uspješno dodan.');
    }
    

    // Prikazuje formu za uređivanje proizvoda
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit-product', compact('product'));
    }

    // Ažurira proizvod u bazi
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Proizvod je uspješno ažuriran.');
    }

    // Briše proizvod iz baze
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Proizvod je uspješno obrisan.');
    }
}
