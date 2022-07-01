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
            $table->string('content_type');
            $table->text('image');
            $table->text('short_description');
            $table->text('description');
            $table->text('author');
            $table->text('position');
            $table->text('og_title')->nullable(true);
            $table->text('og_description')->nullable(true);
            $table->text('og_image')->nullable(true);
            $table->text('og_locale')->nullable(true);
            $table->text('fb_pages')->nullable(true);
            $table->text('fb_app_id')->nullable(true);
            $table->text('fb_image')->nullable(true);
            $table->text('twitter_image')->nullable(true);
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
