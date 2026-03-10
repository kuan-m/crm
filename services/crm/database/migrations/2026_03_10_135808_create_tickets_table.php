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
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')
                    ->constrained()
                    ->onDelete('cascade');
                $table->string('subject');
                $table->text('text');

                $table->unsignedTinyInteger('status')
                    ->default(1)
                    ->index()
                    ->comment('1 – новый, 2 – в работе, 3 – обработан');
                    
                $table->timestamp('replied_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
