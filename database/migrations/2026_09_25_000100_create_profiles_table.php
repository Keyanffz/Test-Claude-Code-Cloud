<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('headline');
            $table->text('short_bio')->nullable();
            $table->text('long_bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->string('cv_path')->nullable();
            $table->boolean('open_to_work')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
