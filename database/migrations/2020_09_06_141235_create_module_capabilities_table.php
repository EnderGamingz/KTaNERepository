<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleCapabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_capabilities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id');
            $table->string('name', 50);
            $table->json('data');
            $table->timestamps();

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
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
        Schema::dropIfExists('module_capabilities');
    }
}
