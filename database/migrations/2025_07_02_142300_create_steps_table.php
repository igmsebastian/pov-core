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
        Schema::create('process_steps', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('process_id')->index();
            $table->ulid('step_id')->index();

            $table->unsignedSmallInteger('sequence')->default(1)->index()
                ->comment('Order of execution');

            $table->boolean('is_optional')->default(false);
            $table->json('condition')->nullable(); // Optional: if you want step-skipping logic
            $table->json('logs')->nullable();
            $table->timestamps();
        });

        Schema::create('sub_process_steps', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('sub_process_id')->index();
            $table->ulid('step_id')->index();

            $table->unsignedSmallInteger('sequence')->default(1)->index();

            $table->boolean('is_optional')->default(false);
            $table->json('condition')->nullable();
            $table->json('logs')->nullable();
            $table->timestamps();
        });

        Schema::create('steps', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('country', 2)->comment('iso2')->index();

            // Workflow relationships
            $table->ulid('feature_id')->nullable()->index();
            $table->ulid('process_id')->nullable()->index();
            $table->ulid('sub_process_id')->nullable()->index();

            // Step identity
            $table->string('name')->nullable();
            $table->string('label')->nullable();

            // Execution logic
            $table->string('exec_type')->default('controller')->comment('controller | service | job | command');
            $table->string('exec')->comment('Format: Namespace\\Class@method or service_name@method')->index();

            $table->text('description')->nullable();

            // Configs & metadata
            addConfigColumns($table);

            // Status and timestamps
            $table->smallInteger('status')->default(StatusEnum::ACTIVE);
            $table->json('logs')->nullable();
            $table->timestamps();

            // Audit
            addAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
