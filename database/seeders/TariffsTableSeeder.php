<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Удаление всех записей из таблицы перед заполнением
        Tariff::query()->delete();

        // Создание тарифов
        Tariff::create([
            'ration_name' => 'Стандартный Рацион',
            'cooking_day_before' => false,
        ]);

        Tariff::create([
            'ration_name' => 'Премиум Рацион',
            'cooking_day_before' => true,
        ]);

        Tariff::create([
            'ration_name' => 'Экономный Рацион',
            'cooking_day_before' => false,
        ]);

        Tariff::create([
            'ration_name' => 'Безглютеновый Рацион',
            'cooking_day_before' => true,
        ]);

        Tariff::create([
            'ration_name' => 'Вегетарианский Рацион',
            'cooking_day_before' => false,
        ]);
    }
}
