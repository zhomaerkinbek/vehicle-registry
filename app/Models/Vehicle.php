<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_number', 'brand', 'model'];

    public function ownerHistory(){
        return $this->hasMany(OwnerHistory::class, 'vehicle_number', 'vehicle_number');
    }
}
