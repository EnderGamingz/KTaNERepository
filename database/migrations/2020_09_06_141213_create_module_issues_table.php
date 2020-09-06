<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_issues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id');
            $table->integer('weight');
            $table->string('type', 25);
            $table->string('description');
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
        Schema::dropIfExists('module_issues');
    }
}
