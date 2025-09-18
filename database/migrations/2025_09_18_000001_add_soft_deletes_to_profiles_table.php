<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Add deleted_at column for soft deletes
            $table->softDeletes();
            // Drop existing unique index on email and replace with composite unique (email, deleted_at)
            $table->dropUnique('profiles_email_unique');
            $table->unique(['email', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Revert composite unique index and soft deletes
            // The default name for the composite unique created above is 'profiles_email_deleted_at_unique'
            $table->dropUnique('profiles_email_deleted_at_unique');
            $table->dropSoftDeletes();
            $table->unique('email');
        });
    }
};
