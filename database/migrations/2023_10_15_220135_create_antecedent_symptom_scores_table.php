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
        Schema::create('antecedent_symptom_scores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('rule_id')->constrained()->unique();
            $table->float('from')->nullable();
            $table->float('to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antecedent_symptom_scores');
    }
};
