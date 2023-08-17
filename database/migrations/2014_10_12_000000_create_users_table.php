<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('birthdate')->nullable();
            $table->string('password');
            $table->string('image');
            $table->enum('role', ['user', 'admin']);
            $table->string('referralLink');
            $table->string('registeredBy')->nullable();
            $table->integer('numberOfUserRegistered')->default(0);
            $table->integer('numberOfUserVisited')->default(0);
            $table->enum('level', ['Novice Referrer', 'Expert Referrer', 'Master Referrer'])->default('Novice Referrer');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
