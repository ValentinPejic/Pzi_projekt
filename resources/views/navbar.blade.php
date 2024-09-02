<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1F2937; /* Tamna pozadina za navbar */
            padding: 0.5rem; /* Smanjeno za 50% */
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .nav-left {
            display: flex;
            gap: 2rem; /* Razmak između linkova, povećano na 2rem */
        }

        .nav-center {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .nav-right {
            display: flex;
            gap: 2rem; /* Povećani razmak između dugmeta za odjavu i ikone košarice */
            align-items: center;
        }

        nav a {
            color: white; /* Bijela boja teksta za linkove */
            text-decoration: none;
            font-size: 1.125rem; /* Smanjena veličina fonta za manje visine */
        }

        nav a:hover {
            text-decoration: underline; /* Podvlačenje linkova pri prelasku miša */
        }

        nav .container img {
            width: 24px; /* Smanjena veličina ikona za manju visinu */
            height: 24px;
        }

        /* Stil za plavi dugme */
        .btn-blue {
            background-color: #007BFF; /* Plava pozadina */
            color: white; /* Bijela boja teksta */
            padding: 0.5rem 1rem; /* Dodajte padding za bolje prikazivanje */
            border-radius: 0.25rem; /* Zaobljeni kutovi */
            text-decoration: none; /* Ukloni podcrtavanje */
            display: inline-block; /* Inline blok za pravilno prikazivanje */
        }

        .btn-blue:hover {
            background-color: #0056b3; /* Tamnija plava za hover */
        }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <!-- Lijeva strana navbar-a -->
            <div class="nav-left">
                <a href="{{ url('/') }}" class="text-white text-lg font-bold hover:underline">Početna</a>
                <!-- Dodajte link za "Moje narudžbe" -->
                <a href="{{ route('orders.show') }}" class="text-white text-lg font-bold hover:underline">Moje narudžbe</a>
            </div>

            <!-- Sredina navbar-a -->
            <div class="nav-center">
                @auth
                    <span class="text-white text-base lg:text-xl">
                        Dobrodošli, {{ Auth::user()->name }}
                    </span>
                @endauth
            </div>

            <!-- Desna strana navbar-a -->
            <div class="nav-right">
                @auth
                    <!-- Dugme za odjavu -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-blue">Odjava</button>
                    </form>
                    <!-- Ikona košarice -->
                    <a href="{{ route('cart') }}" class="text-white">
                        <img src="{{ asset('images/cart-icon.png') }}" alt="Košarica" class="w-8 h-8">
                    </a>
                @else
                    <a href="{{ route('register') }}" class="text-white text-base lg:text-xl hover:underline">Registar</a>
                    <a href="{{ route('login') }}" class="text-white text-base lg:text-xl hover:underline">Login</a>
                    <a href="{{ route('cart') }}" class="text-white">
                        <img src="{{ asset('images/cart-icon.png') }}" alt="Košarica" class="w-8 h-8">
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</body>
</html>
