<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\OwnerHistory;
use Illuminate\Support\Facades\DB;

class VehicleControllerTest extends TestCase
{
   
    use RefreshDatabase;

    public function testRegisterVehicle()
    {
        $response = $this->post('/register', [
            'owner_name' => 'Иванов Иван',
            'brand' => 'Toyota',
            'model' => 'Camry',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success');
        $this->assertStringStartsWith('Автомобиль с номером', session('success'));

        
        $this->assertDatabaseHas('vehicles', [
            'brand' => 'Toyota',
            'model' => 'Camry',
        ]);

        
        $this->assertDatabaseHas('owner_histories', [
            'owner_name' => 'Иванов Иван',
        ]);
    }
    public function testReRegisterVehicle()
    {
    
        $vehicle = Vehicle::create([
            'vehicle_number' => 'AUTO-123456',
            'brand' => 'Honda',
            'model' => 'Civic',
        ]);
        
        OwnerHistory::create([
            'vehicle_number' => $vehicle->vehicle_number,
            'owner_name' => 'Петров Петр',
            'registered_at' => now(),
            'transferred_at' => null,
        ]);

        
        $response = $this->post('/re-register', [
            'vehicle_number' => $vehicle->vehicle_number,
            'new_owner_name' => 'Сидоров Сидор',
        ]);

        
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'Автомобиль с номером ' . $vehicle->vehicle_number . ' успешно переоформлен.');

        
        $this->assertDatabaseHas('owner_histories', [
            'owner_name' => 'Сидоров Сидор',
            'vehicle_number' => $vehicle->vehicle_number,
        ]);

        
        $this->assertDatabaseHas('owner_histories', [
            'owner_name' => 'Петров Петр',
        ]);
        
        
        $history = OwnerHistory::where('owner_name', 'Петров Петр')->first();
        $this->assertNotNull($history->transferred_at);
    }
    public function testShowStats()
    {
        // Создаем автомобили
        Vehicle::create([
            'vehicle_number' => 'AUTO-111111',
            'brand' => 'Toyota',
            'model' => 'Corolla',
        ]);
        Vehicle::create([
            'vehicle_number' => 'AUTO-222222',
            'brand' => 'Toyota',
            'model' => 'Corolla',
        ]);
        Vehicle::create([
            'vehicle_number' => 'AUTO-333333',
            'brand' => 'Honda',
            'model' => 'Civic',
        ]);

        // Запрос на страницу статистики
        $response = $this->get('/stats');

        // Проверка, что выводятся данные
        $response->assertStatus(200);
        $response->assertSee('Toyota');
        $response->assertSee('Corolla');
        $response->assertSee('Honda');
        $response->assertSee('Civic');
    }
    public function testShowHistory()
    {
        // Создаем автомобиль и историю владельцев
        $vehicle = Vehicle::create([
            'vehicle_number' => 'AUTO-123456',
            'brand' => 'BMW',
            'model' => 'X5',
        ]);
        OwnerHistory::create([
            'vehicle_number' => $vehicle->vehicle_number,
            'owner_name' => 'Смирнов Сергей',
            'registered_at' => now(),
            'transferred_at' => null,
        ]);
        OwnerHistory::create([
            'vehicle_number' => $vehicle->vehicle_number,
            'owner_name' => 'Кузнецов Дмитрий',
            'registered_at' => now()->addDay(),
            'transferred_at' => null,
        ]);

        // Запрос на историю
        $response = $this->get('/history?vehicle_number=' . $vehicle->vehicle_number);

        // Проверка, что выводятся данные истории
        $response->assertStatus(200);
        $response->assertSee('Смирнов Сергей');
        $response->assertSee('Кузнецов Дмитрий');
    }

}
