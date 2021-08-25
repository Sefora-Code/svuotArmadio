<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade');
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->foreign('assigned_by')
                ->references('id')
                ->on('employees');
            // quando il mezzo e' stato restituito
            $table->dateTime('returned_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_vehicles');
    }
}
