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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->date('founded_date')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->string('field')->nullable();
            $table->unsignedBigInteger('registered_by');

            $table->foreign('registered_by')
                ->references('id')
                ->on('admins')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
