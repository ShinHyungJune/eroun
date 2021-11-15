<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string("name_company"); // 업체명
            $table->string("name_president"); // 대표명
            $table->string("number_company"); // 사업자번호
            $table->string("contact"); //연락처
            $table->string("charger_privacy"); // 개인정보처리책임자
            $table->string("facebook")->nullable(); // 페이스북 url
            $table->string("instagram")->nullable(); // 인스타그램 url
            $table->string("kakao")->nullable(); // 카카오톡 url
            $table->string("youtube")->nullable(); // 유튜브 url
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
        Schema::dropIfExists('information');
    }
}
