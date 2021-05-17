<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('qrs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 1000);
            $table->string('enlace', 1000)->nullable();
            $table->string('codigo');
            $table->string('documento')->nullable();
            $table->foreignId('id_servicio')->constraint('servicios')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('qrs');
    }
}
