<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function placeOrder(Request $request) {
        // Dohvati podatke iz košarice
        $cartItems = Session::get('cart', []);

        if (empty($cartItems)) {
            return response()->json(['error' => 'Košarica je prazna.'], 400);
        }

        // Stvaranje nove narudžbe
        $order = Order::create([
            'user_id' => auth()->id(), // Ako koristite autentifikaciju
            'total' => array_reduce($cartItems, function ($carry, $item) {
                return $carry + ($item['quantity'] * $item['price']);
            }, 0),
        ]);

        // Spremanje stavki narudžbe
        foreach ($cartItems as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Očisti košaricu
        Session::forget('cart');

        // Vratite uspješan odgovor
        return response()->json(['success' => true]);
    }

// OrderController.php
public function showOrders()
{
    $orders = Order::where('user_id', auth()->id())->with('items')->get();
    return view('my-orders', ['orders' => $orders]);
}


}
