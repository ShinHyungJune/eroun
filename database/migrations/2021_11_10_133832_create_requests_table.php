<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("worker_id")->nullable();
            $table->foreign("worker_id")->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("contact"); // 연락처
            $table->string("category"); // 분야
            $table->integer("time"); // 전문가 사용시간
            $table->string("address"); // 장소
            $table->integer("price"); // 희망금액
            $table->string("style"); // 원하는 진행스타일
            $table->text("comment")->nullable(); // 기타
            $table->dateTime("required_at"); // 필요날짜
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
        Schema::dropIfExists('requests');
    }
}
