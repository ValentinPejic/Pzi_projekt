<!-- resources/views/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css') <!-- Ako koristiš Vite -->
</head>

<body class="bg-gray-200 flex-col min-h-screen">
    <!-- Navigacijski bar -->
    <br>
    <br>
    <br>
    <br>
    <br>
    @include('navbar')

    <!-- Glavni sadržaj -->
    <main class="flex-grow flex items-center justify-center">
    <form action="{{ route('register.submit') }}" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-auto mt-10">
    @csrf
    <h1 class="text-2xl font-bold mb-4 text-center">Registracija</h1>

    <!-- Prikaz grešaka -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Ime i Prezime</label>
        <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Broj mobitela</label>
        <input type="text" id="phone" name="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Adresa</label>
        <input type="text" id="address" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="health_id" class="block text-sm font-medium text-gray-700">Zdravstveni ID</label>
        <input type="text" id="health_id" name="health_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Lozinka</label>
        <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Potvrdi Lozinku</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-opacity-50" required>
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">Registruj se</button>
</form>



        </div>
    </main>
</body>
</html>
