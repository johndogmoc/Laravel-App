<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'age')) {
                $table->dropColumn('age');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'age')) {
                $table->unsignedTinyInteger('age')->nullable()->after('last_name');
            }
        });
    }
};
