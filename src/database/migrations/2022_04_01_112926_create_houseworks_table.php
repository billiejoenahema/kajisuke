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
        Schema::create('houseworks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID')->index();
            $table->unsignedBigInteger('category_id')->comment('カテゴリ')->index();

            $table->string('title')->comment('タイトル');
            $table->string('comment')->comment('コメント')->nullable();
            $table->integer('cycle_num')->comment('実行周期数値');
            $table->integer('cycle_unit')->comment('実行周期単位');
            $table->date('next_date')->comment('次回実施日');
            $table->datetimes();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseworks');
    }
};
