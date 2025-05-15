<?php

use Illuminate\Database\Schema\Blueprint;

if (!function_exists('addAuditColumns')) {
    function addAuditColumns(Blueprint $table): void {
        $table->ulid('created_by')->nullable();
        $table->string('created_by_email')->nullable();

        $table->ulid('updated_by')->nullable();
        $table->string('updated_by_email')->nullable();
    }
}

if (!function_exists('addConfigColumns')) {
    function addConfigColumns(Blueprint $table): void {
        $table->json('configs')->nullable();
        $table->json('metas')->nullable();
    }
}