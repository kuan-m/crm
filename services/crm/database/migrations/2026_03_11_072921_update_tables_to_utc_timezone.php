<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('tickets')) {

            Schema::table('tickets', function (Blueprint $table) {

                if (Schema::hasColumn('tickets', 'replied_at')) {
                    $table->timestampTz('replied_at')->nullable()->change();
                }

                if (Schema::hasColumn('tickets', 'created_at')) {
                    $table->timestampTz('created_at')
                        ->useCurrent()
                        ->change();
                }

                if (Schema::hasColumn('tickets', 'updated_at')) {
                    $table->timestampTz('updated_at')
                        ->useCurrent()
                        ->useCurrentOnUpdate()
                        ->change();
                }
            });

        }

        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {

                if (Schema::hasColumn('users', 'email_verified_at')) {
                    $table->timestampTz('email_verified_at')
                        ->nullable()
                        ->change();
                }

                if (Schema::hasColumn('users', 'created_at')) {
                    $table->timestampTz('created_at')
                        ->useCurrent()
                        ->change();
                }

                if (Schema::hasColumn('users', 'updated_at')) {
                    $table->timestampTz('updated_at')
                        ->useCurrent()
                        ->useCurrentOnUpdate()
                        ->change();
                }
            });

        }

        if (Schema::hasTable('password_reset_tokens')) {

            Schema::table('password_reset_tokens', function (Blueprint $table) {

                if (Schema::hasColumn('password_reset_tokens', 'created_at')) {
                    $table->timestampTz('created_at')
                        ->nullable()
                        ->change();
                }

            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tickets')) {

            Schema::table('tickets', function (Blueprint $table) {

                if (Schema::hasColumn('tickets', 'replied_at')) {
                    $table->timestamp('replied_at')->nullable()->change();
                }

                if (Schema::hasColumn('tickets', 'created_at')) {
                    $table->timestamp('created_at')->change();
                }

                if (Schema::hasColumn('tickets', 'updated_at')) {
                    $table->timestamp('updated_at')->change();
                }
            });

        }

        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {

                if (Schema::hasColumn('users', 'email_verified_at')) {
                    $table->timestamp('email_verified_at')->nullable()->change();
                }

                if (Schema::hasColumn('users', 'created_at')) {
                    $table->timestamp('created_at')->change();
                }

                if (Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamp('updated_at')->change();
                }
            });

        }

        if (Schema::hasTable('password_reset_tokens')) {

            Schema::table('password_reset_tokens', function (Blueprint $table) {

                if (Schema::hasColumn('password_reset_tokens', 'created_at')) {
                    $table->timestamp('created_at')->nullable()->change();
                }

            });

        }
    }
};
