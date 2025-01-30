<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Order</title>
    <link rel="stylesheet" href="{{ asset('css/orders/create.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>
<body>
<header>
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
    <h1>Create Order</h1>
</header>
<nav>
    <a href="{{ route('orders.index') }}" class="btn">Back to Orders</a>
</nav>
<main>
{{--    <form action="{{ url('/test-order-validation') }}" method="POST" class="form">--}}
    <form action="{{ route('orders.store') }}" method="POST" class="form" onsubmit="return validateForm()">
        @csrf
        <div class="form-group">
            <label for="client_name">Client Name:</label>
            <input type="text" name="client_name" required class="form-control">
        </div>
        <div class="form-group">
            <label for="client_phone">Client Phone:</label>
            <input type="text" name="client_phone" required class="form-control" pattern="^7\d{10}$" title="Phone number must be in the format 79991112233">
        </div>
        <div class="form-group">
            <label for="tariff_id">Tariff:</label>
            <select name="tariff_id" required class="form-control">
                @foreach($tariffs as $tariff)
                    <option value="{{ $tariff->id }}">{{ $tariff->ration_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="schedule_type">Schedule Type:</label>
            <select name="schedule_type" required class="form-control">
                <option value="EVERY_DAY">Every Day</option>
                <option value="EVERY_OTHER_DAY">Every Other Day</option>
                <option value="EVERY_OTHER_DAY_TWICE">Every Other Day Twice</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" class="form-control"></textarea>
        </div>
        <div id="date_ranges" class="form-group">
            <div class="date_range">
                <label for="start">Start Date:</label>
                <input type="date" name="date_ranges[0][start]" required class="form-control">
                <label for="end">End Date:</label>
                <input type="date" name="date_ranges[0][end]" required class="form-control">
            </div>
        </div>
        <button type="button" onclick="addDateRange()" class="btn">Add Date Range</button>
        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</main>
<footer>
    <p>&copy; 2023 Orders Management System. All rights reserved.</p>
</footer>
<script>
    let count = 1;
    function addDateRange() {
        const container = document.getElementById('date_ranges');
        const div = document.createElement('div');
        div.className = 'date_range';
        div.innerHTML = `
                <label for="start">Start Date:</label>
                <input type="date" name="date_ranges[${count}][start]" required class="form-control">
                <label for="end">End Date:</label>
                <input type="date" name="date_ranges[${count}][end]" required class="form-control">
            `;
        container.appendChild(div);
        count++;
    }

    function validateForm() {
        const dateRanges = document.querySelectorAll('.date_range');
        let isValid = true;

        dateRanges.forEach(range => {
            const startDate = range.querySelector('[name^="date_ranges"][name$="[start]"]').value;
            const endDate = range.querySelector('[name^="date_ranges"][name$="[end]"]').value;

            if (new Date(startDate) > new Date(endDate)) {
                alert('Start Date must be less than or equal to End Date.');
                isValid = false;
            }
        });

        return isValid;
    }
</script>
</body>
</html>
