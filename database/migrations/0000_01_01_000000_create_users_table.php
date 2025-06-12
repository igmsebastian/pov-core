<?php

use App\Enums\RoleEnum;
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
        Schema::create('roles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code')->unique();
            $table->timestamps();

            addAuditColumns($table);
            addConfigColumns($table);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('action');
            $table->string('resource');
            $table->string('category')->nullable();
            $table->string('scope')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            addAuditColumns($table);
            addConfigColumns($table);

            $table->unique(['action', 'resource']);
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->ulid('role_id');
            $table->ulid('permission_id');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $driver = Schema::getConnection()->getDriverName();

            $table->ulid('id')->primary();
            $table->string('guid')->nullable();
            $table->string('samaccountname')->unique();
            $table->text('dn')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();

            if ($driver !== 'sqlsrv') {
                $table->unique('guid');
            }

            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('division')->nullable();
            $table->text('memberof')->nullable();
            $table->string('department')->nullable();
            $table->string('departmentNumber')->nullable();
            $table->string('manager')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('lead')->nullable();
            $table->string('lead_email')->nullable();
            $table->ulid('team_id')->nullable()->index();
            $table->smallInteger('status')->default(StatusEnum::ACTIVE);
            $table->timestamps();

            addAuditColumns($table);
            addConfigColumns($table);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->ulid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
