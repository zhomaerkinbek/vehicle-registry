<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_histories', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number');
            $table->string('owner_name');
            $table->timestamp('registered_at')->default(DB::raw('CURRENT_TIMESTAMP')); // Дата регистрации
            $table->timestamp('transferred_at')->nullable(); // Дата переоформления
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_histories');
    }
}
