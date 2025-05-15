<?php

use App\Enums\StatusEnum;
use App\Helpers\SchemaHelper;
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
        Schema::create('countries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('region_id')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code', 2)->unique();
            $table->string('alpha3', 3)->nullable();
            $table->string('numeric', 3)->nullable();
            $table->string('phone_code')->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name')->nullable();
            $table->string('flag_url')->nullable();
            $table->string('subregion')->nullable();
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
        Schema::dropIfExists('countries');
    }
};
