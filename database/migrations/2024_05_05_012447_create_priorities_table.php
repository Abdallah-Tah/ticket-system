<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('priorities')->insert([
            ['name' => 'Low', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medium', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'High', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urgent', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
