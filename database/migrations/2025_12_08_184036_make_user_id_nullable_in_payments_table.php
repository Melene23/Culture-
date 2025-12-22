<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('payments') || !Schema::hasColumn('payments', 'user_id')) {
            return;
        }

        $constraints = DB::select(
            "select c.conname as name\n" .
            "from pg_constraint c\n" .
            "join pg_class t on t.oid = c.conrelid\n" .
            "where c.contype = 'f'\n" .
            "and t.relname = 'payments'\n" .
            "and pg_get_constraintdef(c.oid) like '%(user_id)%'"
        );

        foreach ($constraints as $constraint) {
            if (!empty($constraint->name)) {
                DB::statement('alter table "payments" drop constraint if exists "' . $constraint->name . '"');
            }
        }

        Schema::table('payments', function (Blueprint $table) {
            // Rendre user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('payments') || !Schema::hasColumn('payments', 'user_id')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            // Remettre user_id comme non nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });

        $constraints = DB::select(
            "select c.conname as name\n" .
            "from pg_constraint c\n" .
            "join pg_class t on t.oid = c.conrelid\n" .
            "where c.contype = 'f'\n" .
            "and t.relname = 'payments'\n" .
            "and pg_get_constraintdef(c.oid) like '%(user_id)%'"
        );

        if (count($constraints) === 0) {
            Schema::table('payments', function (Blueprint $table) {
                // Remettre la contrainte de clé étrangère
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
};
