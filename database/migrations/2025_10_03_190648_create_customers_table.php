<?php

// database/migrations/2025_10_03_000000_create_customers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $t) {
            $t->id();
            $t->string('code', 50)->unique();
            $t->string('name')->index();
            $t->string('address')->nullable();
            $t->string('phone', 32)->nullable();
            $t->string('email')->nullable()->index();

            // Foreign keys MSSQL uyumlu
            $t->foreignId('created_by')
                ->nullable()
                ->constrained('users'); // onDelete belirtilmezse = NO ACTION

            $t->foreignId('updated_by')
                ->nullable()
                ->constrained('users'); // yine NO ACTION

            $t->timestamps();
            $t->softDeletes();
        });

        // MSSQL için ek index (opsiyonel ama tavsiye)
        // Schema::table('customers', fn(Blueprint $t) => $t->index('code'));
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
