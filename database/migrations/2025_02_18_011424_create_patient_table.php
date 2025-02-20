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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('sex');
            $table->date('bdate');
            $table->string('civstat');
            $table->string('nlity');
            $table->string('hadd');
            $table->string('badd')->nullable();
            $table->string('pnum');
            $table->string('email')->unique();
            $table->string('philnum')->nullable();
            $table->string('occup')->nullable();
            $table->string('rlgion')->nullable();
            $table->boolean('dpcon')->default(false);
            $table->boolean('sdel')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
