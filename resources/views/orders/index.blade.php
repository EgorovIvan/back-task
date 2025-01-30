<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="{{ asset('css/orders/index.css') }}">
    <link rel="icon" href="../../../public/images/logo.png" type="image/png">
</head>
<body>
<header>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
    <h1>Orders</h1>
</header>
<nav>
    <a href="{{ route('orders.create') }}" class="btn">Create New Order</a>
</nav>
<main>
    <ul class="order-list">
        @foreach($orders as $order)
            <li class="order-item">
                <span class="client-name">{{ $order->client_name }}</span> -
                <span class="client-phone">{{ $order->client_phone }}</span> -
                <span class="tariff-name">{{ $order->tariff->ration_name }}</span>
                <a href="{{ route('orders.show', $order->id) }}" class="view-btn">View</a>
            </li>
        @endforeach
    </ul>
</main>
<footer>
    <p>&copy; 2023 Orders Management System. All rights reserved.</p>
</footer>
</body>
</html>
