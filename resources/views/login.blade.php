<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css') <!-- Ako koristiš Vite -->
</head>
<body class="bg-gray-200 flex-col min-h-screen">

    <br>
    <br>
    <br>
    <br>
    <br>
    
    <!-- Uključi navigacijsku traku -->
    @include('navbar')

    <!-- Glavni sadržaj -->
    <div class="flex-grow flex items-center justify-center mt-16">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Login</h1>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Lozinka</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">Prijavi se</button>
            </form>
            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Nemate račun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Registrujte se</a></span>
            </div>
        </div>
    </div>
</body>
</html>
