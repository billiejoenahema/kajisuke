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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID')->index();
            $table->string('image')->comment('プロフィール画像')->nullable();
            $table->string('last_name')->comment('姓')->nullable();
            $table->string('first_name')->comment('名')->nullable();
            $table->string('gender', 1)->comment('性別')->default('0');
            $table->date('birth')->comment('生年月日')->nullable();
            $table->string('tel')->comment('電話番号')->nullable();
            $table->string('zipcode1', 3)->comment('郵便番号1')->nullable();
            $table->string('zipcode2', 4)->comment('郵便番号2')->nullable();
            $table->string('prefecture')->comment('都道府県')->nullable();
            $table->string('city')->comment('市町村')->nullable();
            $table->string('street_address')->comment('町丁目以下')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('profiles');
    }
};
