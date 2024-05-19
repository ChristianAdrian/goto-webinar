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
        Schema::create('webinar', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->text('gotowebinar_id')->nullable();
            $table->text('gotowebinar_panelist_count')->nullable();
            $table->text('gotowebinar_user_count')->nullable();
            $table->timestamp('gotowebinar_last_updated_date')->nullable();
            $table->foreignId('event_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinar');
    }
};
