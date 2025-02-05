<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
    public static function generateUniqueNumber()
    {
        do {
            $number = 'AUTO-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Vehicle::where('vehicle_number', $number)->exists());

        return $number;
    }
}