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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alias');
            $table->string('author')->nullable(true);
            $table->string('position')->nullable(true);
            $table->text('shortdescription');
            $table->text('description');
            $table->string('contenttype');
            $table->double('sortorder')->default(0)->nullable(true);
            $table->text('image')->nullable(true);
            $table->text('ogimage')->nullable(true);
            $table->text('twitterimage')->nullable(true);
            $table->text('keywords')->nullable(true);
            $table->text('gallery')->nullable(true);
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
        Schema::dropIfExists('contents');
    }
};
