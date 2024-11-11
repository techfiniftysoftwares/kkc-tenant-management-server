<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {


        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->string('unit_number');
            $table->enum('status', ['vacant', 'occupied', 'maintenance', 'reserved']);
            $table->decimal('rent_amount', 10, 2);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('square_footage', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['property_id', 'unit_number']);
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('id_number')->unique();
            $table->text('address_history')->nullable();
            $table->text('employment_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('unit_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->date('lease_start_date');
            $table->date('lease_end_date')->nullable(); // Made nullable for month-to-month leases
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->integer('rent_due_day')->default(1); // Day of month rent is due (1-28)
            $table->enum('payment_status', ['paid', 'unpaid', 'late'])->default('unpaid');
            $table->date('last_payment_date')->nullable();
            $table->enum('lease_status', ['active', 'expired', 'terminated']);
            $table->text('lease_terms')->nullable();
            $table->text('termination_reason')->nullable();
            $table->date('termination_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Modified unique constraint to allow historical records
            $table->unique(['unit_id', 'tenant_id', 'lease_start_date']);
        });

        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->string('password');
        //     $table->enum('role', ['admin', 'property_manager', 'maintenance', 'accountant']);
        //     $table->boolean('is_active')->default(true);
        //     $table->string('phone')->nullable();
        //     $table->text('address')->nullable();
        //     $table->string('employee_id')->unique()->nullable();
        //     $table->rememberToken();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        Schema::create('property_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('property_id')->constrained('properties');
            $table->date('assignment_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            // Modified to allow historical property manager assignments
            $table->unique(['property_id', 'status', 'user_id']);
        });

        Schema::create('unit_tenant_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_tenant_id')->constrained('unit_tenants');
            $table->date('payment_date');
            $table->date('payment_for_month');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_tenant_payments');
        Schema::dropIfExists('property_managers');

        Schema::dropIfExists('unit_tenants');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('units');

    }
};
