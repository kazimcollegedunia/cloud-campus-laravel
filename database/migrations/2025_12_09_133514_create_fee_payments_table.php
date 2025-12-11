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
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('fee_id');

            $table->enum('payment_mode', ['cash','online','upi','bank','cheque'])->default('online');
            $table->decimal('amount_inr', 10, 2);

            $table->string('transaction_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();

            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
