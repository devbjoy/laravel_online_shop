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
        Schema::table('orders',function(Blueprint $table){
            $table->string('first_name')->after('grand_total');
            $table->string('last_name')->after('first_name');
            $table->string('email')->after('last_name');
            $table->string('mobile')->after('email');
            $table->foreignId('country_id')->constrained()->onDelete('cascade')->after('mobile');
            $table->string('address')->after('country_id');
            $table->string('apartment')->nullable()->after('address');
            $table->string('city')->after('apartment');
            $table->string('state')->after('city');
            $table->string('zip')->after('state');
            $table->string('notes')->nullable()->after('zip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
