<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextareasBeforeAfterToTeachingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachings', function (Blueprint $table) {
            //
            $table->text('before_text')->nullable();
            $table->text('after_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachings', function (Blueprint $table) {
            //
            $table->dropColumn('before_text');
            $table->dropColmn('after_text');
        });
    }
}
