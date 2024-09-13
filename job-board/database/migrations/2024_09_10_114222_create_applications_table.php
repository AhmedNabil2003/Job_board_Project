<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The candidate who applied
            $table->foreignId('job_listing_id')->constrained('jobs_listings')->onDelete('cascade'); // Updated table name
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('pending'); // e.g., 'pending', 'accepted', 'rejected'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
