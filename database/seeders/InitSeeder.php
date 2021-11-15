<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Information;
use App\Models\User;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "쇼호스트",
            "MC",
            "대행사",
            "스튜디오",
            "기타"
        ];

        $workers = [
            "가우 전우성",
            "노을",
            "이민석",
            "성우MC 남기희"
        ];

        $events = [
            "라이브 커머스 쇼호스트 찾고 계세요?",
            "어디에도 없을 갓성비 뮤지컬웨딩",
            "하객 제한 돈워리 사회,축가 한명으로 해결!",
            "믿고 섭외하는 개콘 출신 스타 개그맨!"
        ];

        $companies = [
            "하우스빌 웨딩플랜컴퍼니",
            "SAMSUNG",
            "신라호텔"
        ];

        $information = [
            "name_company" => "이로운컴퍼니",
            "name_president" => "이지훈",
            "number_company" => "201-86-31231",
            "contact" => "070-4773-0080",
            "charger_privacy" => "이지훈",
            "facebook" => "https://naver.com",
            "instagram" => "https://naver.com",
            "kakao" => "https://naver.com",
            "youtube" => "https://naver.com",
        ];

        foreach($categories as $category){
            Category::factory()->create([
                "title" => $category
            ]);
        }

        foreach($workers as $worker){
            User::factory()->create([
                "worker" => true,
                "name" => $worker
            ]);
        }

        foreach($companies as $company){
            Company::factory()->create([
                "title" => $company
            ]);
        }

        Information::create($information);
    }
}
