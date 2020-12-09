<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function salesDetails() {
        return $this->hasMany('App\Models\SalesDetails', 'sale_id');
    }
}
