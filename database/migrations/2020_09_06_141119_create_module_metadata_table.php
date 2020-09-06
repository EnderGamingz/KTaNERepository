<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_metadata', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id');
            $table->string('key', 50);
            $table->text('value');
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
        Schema::dropIfExists('module_metadata');
    }
}
