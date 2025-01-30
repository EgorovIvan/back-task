<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_name', 'client_phone', 'tariff_id', 'schedule_type', 'comment', 'first_date', 'last_date'];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function rations()
    {
        return $this->hasMany(Ration::class);
    }
}
