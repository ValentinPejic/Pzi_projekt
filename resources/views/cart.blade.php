<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Košarica</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        main {
            margin-top: 4rem; /* Promijenite vrijednost po potrebi */
        }
        .quantity-box {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 120px;
            padding: 2px;
            margin: 2px;
        }
        .quantity-box button {
            background-color: #eee;
            border: none;
            padding: 8px;
            cursor: pointer;
            border-radius: 10px;
        }
        .quantity-box input {
            border: none;
            text-align: center;
            width: 45px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
        }
        .cart-item-name {
            flex-grow: 1;
            text-align: left;
        }
        .cart-item-price {
            margin-right: 12px;
        }
        .remove-button {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col min-h-screen">
    <!-- Navigacijska traka -->
    @include('navbar')

    <!-- Glavni sadržaj -->
    <main class="p-4 mt-16">
        <!-- Dodaj razmak sa strane -->
        <div class="px-4">
            <!-- Košarica stavke -->
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold mb-6">Košarica</h1>
                <div class="space-y-6">
                    <!-- Provjeri ima li stavki u košarici -->
                    @forelse($cartItems as $productId => $item)
                        <div class="cart-item">
                            <span class="cart-item-name text-lg font-semibold">{{ $item['name'] }}</span>
                            <span class="cart-item-price text-lg font-semibold">€{{ number_format($item['price'], 2) }}</span>
                            <div class="quantity-box">
                                <button type="button" onclick="changeQuantity('{{ $productId }}', -1)">-</button>
                                <input type="text" value="{{ $item['quantity'] }}" readonly data-product-id="{{ $productId }}">
                                <button type="button" onclick="changeQuantity('{{ $productId }}', 1)">+</button>
                            </div>
                            <button class="remove-button" onclick="removeFromCart('{{ $productId }}')">Ukloni</button>
                        </div>
                    @empty
                        <p class="text-center text-gray-600">Košarica je prazna.</p>
                    @endforelse
                </div>
                <div class="flex justify-between items-center mt-6">
                    <!-- Novi button "Nastavi kupovati" -->
                    <a href="{{ route('home') }}" class="bg-gray-500 text-black py-2 px-4 rounded-md hover:bg-gray-600">Nastavi kupovati</a>
                    <!-- Dugme "Napravi Narudžbu" -->
                    <button class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600" onclick="placeOrder()">Napravi Narudžbu</button>
                </div>
            </div>
        </div>
    </main>
    <script>
        function changeQuantity(productId, change) {
            const input = document.querySelector(`input[data-product-id="${productId}"]`);
            const currentValue = parseInt(input.value);
            const newValue = Math.max(1, currentValue + change);
            input.value = newValue;

            // Pošalji ažuriranje na server
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: productId,
                    quantity: newValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Ažuriraj ukupno u košarici
                    document.getElementById('total').innerText = `Ukupno: €${data.total}`;
                }
            })
            .catch(error => {
                console.error('Greška:', error);
            });
        }

        function removeFromCart(productId) {
            fetch('{{ route('cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Ukloni stavku iz prikaza i ažuriraj ukupno
                    const itemElement = document.querySelector(`.cart-item [data-product-id="${productId}"]`).closest('.cart-item');
                    itemElement.remove();
                    document.getElementById('total').innerText = `Ukupno: €${data.total}`;
                }
            })
            .catch(error => {
                console.error('Greška:', error);
            });
        }

        function placeOrder() {
        fetch('{{ route('order.place') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                // Možete dodati podatke o narudžbi ovdje ako je potrebno
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Narudžba je uspješno poslana!');
                // Osvježi stranicu
                location.reload();
            } else {
                alert('Došlo je do greške pri slanju narudžbe.');
            }
        })
        .catch(error => {
            console.error('Greška:', error);
        });
        }
    </script>
</body>
</html>
