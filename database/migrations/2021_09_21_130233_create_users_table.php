<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->boolean("worker")->default(false); // 일반사용자 | 전문가

            // 공통정보
            $table->string("contact")->nullable(); // 연락처
            $table->string('email')->nullable(); // 이메일
            $table->string("name")->nullable(); // 이름
            $table->string("address")->nullable(); // 주소

            // 전문가정보
            $table->integer("career")->nullable(); // 경력
            $table->integer("count_view")->default(0); // 조회수
            $table->integer("count_request")->default(0); // 견적요청수

            $table->timestamp('verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string("social_id")->nullable();
            $table->string("social_platform")->nullable();
            $table->unique(["social_id", "social_platform"]);
            $table->text("description")->nullable();

            $table->boolean("accepted")->default(false);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
