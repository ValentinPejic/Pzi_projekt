@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Moje Narudžbe</h1>
        @if ($orders->isEmpty())
            <p>Nemate nijednu narudžbu.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ukupno</th>
                        <th>Datum</th>
                        <th>Stavke</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->total }} €</td>
                            <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>
                                <ul>
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->name }} ({{ $item->quantity }})</li>
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
