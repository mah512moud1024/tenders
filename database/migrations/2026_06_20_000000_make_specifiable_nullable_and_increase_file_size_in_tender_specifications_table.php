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
        Schema::table('tender_specifications', function (Blueprint $table) {
            $table->string('specifiable_type')->nullable()->change();
            $table->unsignedBigInteger('specifiable_id')->nullable()->change();
            $table->bigInteger('file_size')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tender_specifications', function (Blueprint $table) {
            $table->string('specifiable_type')->nullable(false)->change();
            $table->unsignedBigInteger('specifiable_id')->nullable(false)->change();
            $table->integer('file_size')->change();
        });
    }
};
