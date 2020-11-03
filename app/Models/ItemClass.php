<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemClass extends Model
{
    use HasFactory;

    public function item() {
        return $this->hasOne('App\Models\Item');
    }
}
