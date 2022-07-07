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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_type');
            $table->text('fullname');
            $table->integer('select_position')->nullable(true);
            $table->string('company')->nullable(true);
            $table->string('phone');
            $table->string('email');
            $table->text('cv')->nullable(true);
            $table->text('message')->nullable();
            $table->boolean('status_mail')->default(0);
            $table->text('free_field')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
