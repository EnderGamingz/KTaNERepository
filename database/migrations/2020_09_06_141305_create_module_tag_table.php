<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_tag', function (Blueprint $table) {
            $table->bigInteger('tag_id');
            $table->bigInteger('module_id');

            $table->primary(['tag_id', 'module_id']);

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('CASCADE');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('module_tag');
    }
}
