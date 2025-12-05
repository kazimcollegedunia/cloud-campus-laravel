<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('school_name', 150);
            $table->string('subdomain', 100)->unique(); // highly used
            $table->string('domain', 150)->nullable();  // optional

            // DB-per-tenant support
            $table->string('db_name', 150)->nullable(); 
            $table->string('db_connection', 50)->default('mysql');

            // subscription
            $table->unsignedBigInteger('plan_id')->nullable();

            // active / inactive / trial
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            $table->timestamps();

            // index for faster subdomain lookup
            $table->index('subdomain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
