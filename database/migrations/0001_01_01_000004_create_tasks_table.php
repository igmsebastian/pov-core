<?php

use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('sub_process_id')->nullable();
            $table->ulid('feature_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE);
            $table->timestamps();

            addAuditColumns($table);
            addConfigColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
