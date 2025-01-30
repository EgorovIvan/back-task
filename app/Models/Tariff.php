<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = ['ration_name', 'cooking_day_before'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
