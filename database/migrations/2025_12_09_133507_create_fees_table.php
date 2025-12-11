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
       Schema::create('fees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('fee_type_id');

            $table->decimal('amount_inr', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();

            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'partial', 'failed'])->default('pending');

            $table->string('receipt_no')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->text('remarks')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->onDelete('cascade');

            $table->index(['tenant_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
