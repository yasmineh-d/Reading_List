<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->date('publication_date')->nullable()->change();
            $table->string('ISBN')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->date('publication_date')->nullable(false)->change();
            $table->string('ISBN')->nullable(false)->change();
        });
    }
};
