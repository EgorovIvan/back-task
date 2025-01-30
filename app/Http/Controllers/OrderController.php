<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ration;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('tariff', 'rations')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $tariffs = Tariff::all();
        return view('orders.create', compact('tariffs'));
    }

    public function show($id)
    {
        $order = Order::with('tariff', 'rations')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_name' => 'required|string',
            'client_phone' => 'required|string|unique:orders|regex:/^7\d{10}$/',
            'tariff_id' => 'required|exists:tariffs,id',
            'schedule_type' => 'required|in:EVERY_DAY,EVERY_OTHER_DAY,EVERY_OTHER_DAY_TWICE',
            'comment' => 'nullable|string',
            'date_ranges' => 'required|array|min:1',
            'date_ranges.*.start' => 'required|date',
            'date_ranges.*.end' => 'required|date|after_or_equal:date_ranges.*.start',
        ]);

        $tariff = Tariff::find($validatedData['tariff_id']);

        DB::transaction(function () use ($validatedData, $tariff,) {
            $lastDate = null;
            $firstDate = null;

            $order = Order::create([
                'client_name' => $validatedData['client_name'],
                'client_phone' => $validatedData['client_phone'],
                'tariff_id' => $validatedData['tariff_id'],
                'schedule_type' => $validatedData['schedule_type'],
                'comment' => $validatedData['comment'],
                'first_date' => now(),
                'last_date' => now(),
            ]);

            foreach ($validatedData['date_ranges'] as $range) {
                $dates = $this->generateDeliveryDates($range['start'], $range['end'], $validatedData['schedule_type']);
                foreach ($dates as $date) {
                    $cookingDate = $tariff->cooking_day_before ? Carbon::parse($date)->subDay() : Carbon::parse($date);
                    $ration = new Ration([
                        'order_id' => $order->id,
                        'cooking_date' => $cookingDate,
                        'delivery_date' => $date,
                    ]);
                    $ration->save();

                    if ($firstDate === null || $date < $firstDate) {
                        $firstDate = $date;
                    }

                    if ($lastDate === null || $date > $lastDate) {
                        $lastDate = $date;
                    }
                }
            }

            $order->update(['first_date' => $firstDate, 'last_date' => $lastDate]);
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function testValidation(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'client_name' => 'required|string',
                'client_phone' => 'required|string|unique:orders',
                'tariff_id' => 'required|exists:tariffs,id',
                'schedule_type' => 'required|in:EVERY_DAY,EVERY_OTHER_DAY,EVERY_OTHER_DAY_TWICE',
                'comment' => 'nullable|string',
                'date_ranges' => 'required|array|min:1',
                'date_ranges.*.start' => 'required|date',
                'date_ranges.*.end' => 'required|date|after_or_equal:date_ranges.*.start',
            ]);

            return response()->json(['message' => 'Validation passed', 'data' => $validatedData], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    private function generateDeliveryDates($startDate, $endDate, $scheduleType)
    {
        $dates = [];
        $currentDate = Carbon::parse($startDate);

        while ($currentDate <= Carbon::parse($endDate)) {
            $dates[] = $currentDate->toDateString();
            switch ($scheduleType) {
                case 'EVERY_DAY':
                    $currentDate->addDay();
                    break;
                case 'EVERY_OTHER_DAY':
                    $currentDate->addDays(2);
                    break;
                case 'EVERY_OTHER_DAY_TWICE':
                    $dates[] = $currentDate->copy()->addDay()->toDateString();
                    $currentDate->addDays(2);
                    break;
            }
        }

        return $dates;
    }
}
