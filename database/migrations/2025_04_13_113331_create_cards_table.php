<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('template_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->enum('group_or_individual', ['group', 'individual'])->nullable();
            $table->json('emails')->nullable();
            $table->json('phones')->nullable();
            $table->json('websites')->nullable();
            $table->json('social_media_links')->nullable();
            $table->string('address_logo')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
