<?php

use Illuminate\Database\Schema\Blueprint;

if (!function_exists('addAuditColumns')) {
    function addAuditColumns(Blueprint $table): void {
        $table->uuid('created_by')->nullable();
        $table->string('created_by_email')->nullable();

        $table->uuid('updated_by')->nullable();
        $table->string('updated_by_email')->nullable();

        $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
    }
}