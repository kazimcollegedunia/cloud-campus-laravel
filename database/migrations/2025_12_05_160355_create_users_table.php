<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Foreign Key Tenant
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');

            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();

            $table->enum('role', [
                'super_admin',
                'admin',
                'teacher',
                'student',
                'parent'
            ])->default('student');

            $table->string('password');

            // active/inactive
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            // Multi-tenant optimization
            $table->index(['tenant_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
