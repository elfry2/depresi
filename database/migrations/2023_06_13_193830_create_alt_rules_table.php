<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alt_rules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->unsignedBigInteger('disease_id');
            $table->foreign('disease_id')->references('id')->on('diseases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alt_rules');
    }
};
