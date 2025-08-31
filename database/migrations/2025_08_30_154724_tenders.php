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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained(); // Client who created
            $table->foreignId('city_id')->constrained();
            $table->string('area')->nullable();
            $table->enum('project_type', ['building', 'roads']);
            $table->enum('work_type', ['maintenance', 'new_construction', 'completion']);
            $table->enum('tender_type', ['design', 'construction', 'supply']);
            $table->foreignId('category_id')->constrained('project_categories');
            $table->integer('floors')->nullable();
            $table->decimal('building_area', 10, 2)->nullable();
            $table->decimal('land_area', 10, 2)->nullable();
            $table->string('required_service')->nullable(); // For maintenance projects
            $table->enum('status', ['draft', 'pending', 'published', 'assigned', 'completed'])->default('draft');
            $table->timestamp('closing_date')->nullable();
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
