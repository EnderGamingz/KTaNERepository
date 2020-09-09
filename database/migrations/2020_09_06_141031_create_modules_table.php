<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publisher_id');
            $table->string('uid', 50)->unique();
            $table->string('name', 100);
            $table->string('description');
            $table->bigInteger('steam_id');
            $table->json('credits')->nullable();
            $table->integer('expert_difficulty');
            $table->integer('defuser_difficulty');
            $table->boolean('public')->default(false);
            $table->boolean('approved')->default(false);
            $table->timestamps();

            $table->foreign('publisher_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
