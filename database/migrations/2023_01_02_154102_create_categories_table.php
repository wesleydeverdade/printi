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

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->timestamps();
        });

        Schema::table('movies', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('name');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('movies', function (Blueprint $table) {
            $table->dropForeign('category_id');
            $table->dropIndex('category_id');
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
};
