@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Moje narudžbe</h1>
    @include('navbar')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <style>
        table {
            margin-left: 20px; /* Dodaje razmak s lijeve strane */
            margin-right: 20px; /* Dodaje razmak s desne strane */
        }
        th, td {
            padding: 15px; /* Dodaje razmak unutar ćelija */
        }
    </style>
    @if ($orders->isEmpty())
        <p>Nema narudžbi za prikaz.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Datum</th>
                    <th>Ukupno</th>
                    <th>Stavke</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>{{ number_format($order->total, 2) }} €</td>
                        <td>{{ number_format($order->total * 2, 2) }} KM</td>
                        <td>
                            <ul>
                                @foreach ($order->items as $item)
                                    <li>{{ $item->name }}: {{ $item->quantity }} komada po {{ number_format($item->price, 2) }} €</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
