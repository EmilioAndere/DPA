<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 5);
            $table->string('nombre', 50);
            $table->string('tipo', 20);
            $table->float('lat', 10,6);
            $table->float('lng', 10, 6);
            $table->string('url')->nullable();
            $table->string('codigo_padre', 10);
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
        Schema::dropIfExists('comunas');
    }
}
