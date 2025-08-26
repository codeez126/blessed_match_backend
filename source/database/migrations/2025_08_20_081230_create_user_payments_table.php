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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('type')->default(1); // 1 = plan_purchase, 2 = other_payments
            $table->unsignedBigInteger('type_id')->nullable(); // References payment_plan_id or other entity ID
            $table->unsignedBigInteger('variation_id')->nullable(); // References payment_plan_variation_id or other entity ID
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('PKR');
            $table->tinyInteger('payment_method')->default(1);
            $table->string('payment_proof')->nullable();
            $table->string('transaction_id')->nullable()->unique(); // Unique ID from payment gateway
            $table->text('user_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->tinyInteger('status')->default(0); // 0 = pending, 1 = completed, 2 = failed, 3 = refunded
            $table->json('payment_details')->nullable(); // Store gateway response details
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id', 'type']);
            $table->index(['type', 'type_id']);
            $table->index('status');
            $table->index('transaction_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
