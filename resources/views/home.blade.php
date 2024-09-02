<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite('resources/css/app.css') <!-- Ako koristiš Vite -->
    <style>
        .popup {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
        }

        .main-content {
    margin-top: 5rem; /* Da se ne preklapa s navbarom */
    padding: 2rem; /* Smanji padding za bolji izgled */
    max-width: 1200px; /* Maksimalna širina glavnog sadržaja */
    margin-left: auto; /* Automatski centriraj */
    margin-right: auto; /* Automatski centriraj */
}


        .product-image {
            width: 100%;
            height: 200px; /* Fiksna visina za sve slike */
            object-fit: cover; /* Omogućuje da slike ostanu proporcionalne */
        }

        .products-flex {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 stupca sa ravnotežnim rasporedom */
            gap: 1rem; /* Razmak između proizvoda */
            grid-auto-rows: minmax(200px, auto); /* Automatska visina redaka */
        }

        .product-item {
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col min-h-screen">
    <!-- Navigacijski bar -->
    @include('navbar')

    <!-- Glavni sadržaj -->
    <main class="main-content">
        <!-- Filteri -->
        <div class="flex justify-center mb-4">
            <div class="flex items-center">
                <label for="type" class="mr-2">Vrsta:</label>
                <select id="type" name="type" class="p-2 border border-gray-300 rounded-md">
                    <option value="all">Svi</option>
                    <option value="tablet">Tableta</option>
                    <option value="syrup">Sirup</option>
                    <option value="pill">Pilula</option>
                    <option value="antibiotic">Antibiotik</option>
                    <option value="vitamin">Vitamin</option>
                </select>
            </div>
        </div>

        <!-- Popis lijekova -->
        <div class="products-flex">
            @foreach($products as $product)
                <div class="product-item" data-type="{{ $product->type }}">
                    <!-- Prikaz slike proizvoda -->
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image mb-4 rounded-md">
                    <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-700 mb-2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="bg-green-200 text-black py-1 px-2 rounded-md">{{ $product->price }} €</span>
                    </div>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" required class="border border-gray-300 rounded-md px-2 py-1 mb-2">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Dodaj u Košaricu</button>
                    </form>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Popup obavijest -->
    <div id="popup" class="popup">
        Dodano u košaricu!
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('type');
            
            filterSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                const productItems = document.querySelectorAll('.product-item');
                productItems.forEach(item => {
                    const productType = item.getAttribute('data-type');

                    if (selectedValue === 'all' || selectedValue === productType) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        function addToCart() {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';
            setTimeout(function() {
                popup.style.display = 'none';
            }, 1000);
        }
    </script>

    <script type="module" src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
