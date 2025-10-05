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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('transaction_id')->nullable()->constrained(); // Made nullable
            $table->foreignId('user_id')->constrained();
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled']); // Added cancelled
            $table->text('notes')->nullable();

            // Added fields for commission invoices
            $table->morphs('invoiceable'); // Can link to quotes, tenders, etc.
            $table->decimal('commission_rate', 5, 2)->nullable(); // % commission
            $table->decimal('quote_total_value', 12, 2)->nullable(); // Total quote value
            $table->string('currency', 3)->default('USD');
            $table->text('payment_terms')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
