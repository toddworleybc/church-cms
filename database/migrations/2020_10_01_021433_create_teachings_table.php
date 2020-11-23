<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->integer('staff_id')->nullable();
            $table->string('speaker')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->text('scripture')->nullable();
            $table->date('publish_date');
            $table->string('description')->nullable();
            $table->string('ft_image')->unique()->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachings');
    }
}
