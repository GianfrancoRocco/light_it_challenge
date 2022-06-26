<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_diagnosis', function (Blueprint $table) {
            $table->renameColumn('is_correct', 'marked_as_correct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_diagnosis', function (Blueprint $table) {
            $table->renameColumn('marked_as_correct', 'is_correct');
        });
    }
};
