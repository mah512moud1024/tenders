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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Consultant, Contractor or Supplier
            $table->decimal('amount', 12, 2)->default(0);
            $table->text('proposal')->nullable();
            $table->enum('status', ['submitted', 'under_review', 'accepted', 'rejected'])->default('submitted');
            $table->boolean('selected')->default(false);
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
