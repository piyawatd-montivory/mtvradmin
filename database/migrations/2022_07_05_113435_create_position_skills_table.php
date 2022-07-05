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
        Schema::create('position_skills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('position')
                ->comment('position');
            $table->bigInteger('skill')
                ->comment('skill')->nullable(true);
            $table->bigInteger('interest')
                ->comment('interest')->nullable(true);
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
        Schema::dropIfExists('position_skills');
    }
};
