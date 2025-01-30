<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <link rel="stylesheet" href="{{ asset('css/orders/show.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
<body>
<header>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
    <h1>Order Details</h1>
</header>
<nav>
    <a href="{{ route('orders.index') }}" class="btn">Back to Orders</a>
</nav>
<main>
    <section class="order-details">
        <p><strong>Client Name:</strong> {{ $order->client_name }}</p>
        <p><strong>Client Phone:</strong> {{ $order->client_phone }}</p>
        <p><strong>Tariff:</strong> {{ $order->tariff->ration_name }}</p>
        <p><strong>Schedule Type:</strong> {{ $order->schedule_type }}</p>
        <p><strong>Comment:</strong> {{ $order->comment }}</p>
        <p><strong>First Date:</strong> {{ $order->first_date }}</p>
        <p><strong>Last Date:</strong> {{ $order->last_date }}</p>
    </section>
    <section class="rations">
        <h2>Rations</h2>
        <ul>
            @foreach($order->rations as $ration)
                <li>
                    <strong>Cooking Date:</strong> {{ $ration->cooking_date }},
                    <strong>Delivery Date:</strong> {{ $ration->delivery_date }}
                </li>
            @endforeach
        </ul>
    </section>
</main>
<footer>
    <p>&copy; 2023 Orders Management System. All rights reserved.</p>
</footer>
</body>
</html>
