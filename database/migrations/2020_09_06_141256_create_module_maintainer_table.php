<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleMaintainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_maintainer', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('module_id');

            $table->primary(['user_id', 'module_id']);

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('CASCADE');

            $table->foreign('user_id')
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
        Schema::dropIfExists('module_maintainer');
    }
}
