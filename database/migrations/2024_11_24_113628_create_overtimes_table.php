<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id(); // ID como llave primaria
            $table->string('FK_BOSS', 50);
            $table->longText('EMPLOYEE_LIST');
            $table->date('DATE');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('overtimes');
    }
};
