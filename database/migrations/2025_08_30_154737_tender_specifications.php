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
        Schema::create('tender_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained();
            $table->morphs('specifiable'); // Can be GeneralSpecification or Drawing
            $table->string('file_path');
            $table->string('original_name');
            $table->string('file_type');
            $table->integer('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
