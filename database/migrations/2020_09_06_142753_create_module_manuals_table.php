<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_manuals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id');
            $table->string('language', 25)->default('English');
            $table->string('type')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('source_path')->nullable();
            $table->boolean('allow_js')->default(false);
            $table->boolean('processed')->default(false);
            $table->json('credits')->nullable();
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
        Schema::dropIfExists('module_manuals');
    }
}
