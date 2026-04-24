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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->decimal('amount', 8, 2); // Fine amount
            $table->integer('overdue_days'); // Number of days overdue
            $table->string('status', 20)->default('unpaid')->index(); // unpaid|paid|waived
            $table->timestamp('calculated_at')->useCurrent();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable(); // For recording payment method or reason for waiver
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['calculated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
