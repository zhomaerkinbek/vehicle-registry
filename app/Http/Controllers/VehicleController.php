<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Services\VehicleService;
use App\Models\OwnerHistory;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class VehicleController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'owner_name' => 'required|string|max:255',
        'brand' => 'required|string|max:100',
        'model' => 'required|string|max:100',
    ]);
    
    $vehicle = Vehicle::create([
        'vehicle_number' => VehicleService::generateUniqueNumber(),
        'brand' => $request->brand,
        'model' => $request->model,
    ]);

    OwnerHistory::create([
        'vehicle_number' => $vehicle->vehicle_number,
        'owner_name' => $request->owner_name,
        'registered_at' => now(),
        'transferred_at' => null,
    ]);

    return redirect()->route('home')->with('success', "Автомобиль с номером {$vehicle->vehicle_number} успешно зарегистрирован.");
}
public function reRegister(Request $request)
{
    $request->validate([
        'vehicle_number' => 'required|exists:vehicles,vehicle_number',
        'new_owner_name' => 'required|string|max:255',
    ]);

    // Обновляем старую запись, устанавливая дату передачи
    OwnerHistory::where('vehicle_number', $request->vehicle_number)
        ->whereNull('transferred_at')
        ->update(['transferred_at' => now()]);

    // Добавляем нового владельца
    OwnerHistory::create([
        'vehicle_number' => $request->vehicle_number,
        'owner_name' => $request->new_owner_name,
        'registered_at' => now(),
        'transferred_at' => null,
    ]);

    return redirect()->route('home')->with('success', "Автомобиль с номером {$request->vehicle_number} успешно переоформлен.");
}
    public function showStats()
    {
        $stats = Vehicle::select('brand', 'model')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('brand', 'model')
            ->havingRaw('COUNT(*) > 0')
            ->get();

        return view('stats', ['stats' => $stats->isEmpty() ? [] : $stats]);
    }

    public function showHistory(Request $request)
    {
        $history = [];
        if ($request->has('vehicle_number')) {
            $history = OwnerHistory::where('vehicle_number', $request->vehicle_number)
                ->orderBy('registered_at', 'desc')
                ->get();
        }
        return view('history', compact('history'));
    }

}
