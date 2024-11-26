<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Añadir ID como llave primaria
            $table->string('NO_EMPLOYEE', 10)->unique();
            $table->string('AREA', 30);
            $table->string('NAME', 100);
            $table->string('PHONE', 20);
            $table->string('REASON', 50);
            $table->string('ROUTE', 25);
            $table->string('DINING', 4);
            $table->string('SHIFT', 15);
            $table->string('TIMETABLE', 25);
            $table->string('NOTES', 255)->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
