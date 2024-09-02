<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        // Dohvaćanje stavki iz sesije
        $cartItems = session('cart', []);

        // Izračun ukupnog iznosa
        $total = array_reduce($cartItems, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['price']);
        }, 0);

        return view('cart', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function add(Request $request, $productId)
    {
        // Dohvati proizvod iz baze
        $product = Product::find($productId);
    
        // Ako proizvod ne postoji, vrati grešku
        if (!$product) {
            return redirect()->route('home')->with('error', 'Proizvod ne postoji.');
        }
    
        // Dohvati trenutnu košaricu iz sesije
        $cart = session('cart', []);
    
        // Ako proizvod već postoji u košarici, ažuriraj količinu
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->input('quantity', 1);
        } else {
            // Inače, dodaj proizvod u košaricu bez slike
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->input('quantity', 1),
            ];
        }
    
        // Spremi ažuriranu košaricu u sesiju
        session(['cart' => $cart]);
    
        return redirect()->route('cart')->with('success', 'Proizvod je dodan u košaricu.');
    }

    public function update(Request $request)
    {
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        // Provjeri da li proizvod postoji
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Proizvod ne postoji.'], 404);
        }

        // Dohvati trenutnu košaricu iz sesije
        $cart = session('cart', []);

        // Ako proizvod postoji u košarici, ažuriraj količinu
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session(['cart' => $cart]);

            // Izračunaj novi ukupni iznos
            $total = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            return response()->json(['success' => 'Količina ažurirana.', 'total' => $total]);
        } else {
            return response()->json(['error' => 'Proizvod nije u košarici.'], 404);
        }
    }

    public function remove(Request $request)
    {
        $productId = $request->input('id');

        // Provjera da li je ID proizvoda dostavljen
        if (!$productId) {
            Log::error('Product ID not provided in remove request.');
            return response()->json(['error' => 'Product ID is missing'], 400);
        }

        // Dohvatite stavke iz sesije
        $cart = Session::get('cart', []);

        // Provjerite postoji li stavka u košarici
        if (isset($cart[$productId])) {
            // Uklonite stavku iz košarice
            unset($cart[$productId]);

            // Ažurirajte košaricu u sesiji
            Session::put('cart', $cart);
            Log::info('Product removed from cart', ['product_id' => $productId]);
        } else {
            Log::warning('Attempted to remove product that does not exist in cart', ['product_id' => $productId]);
        }

        // Izračunajte ukupno nakon uklanjanja
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return response()->json([
            'total' => number_format($total, 2),
            'cart' => $cart
        ]);
    }
}
