<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerHistory extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $fillable = ['vehicle_number', 'owner_name'];
    protected $dates = ['registered_at', 'transferred_at'];
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_number', 'vehicle_number');
    }
    public function getRegisteredAtFormattedAttribute()
    {
        return $this->registered_at->format('d.m.Y');  
    }

    public function getTransferredAtFormattedAttribute()
    {
        return $this->transferred_at ? $this->transferred_at->format('d.m.Y') : null; 
    }
}
