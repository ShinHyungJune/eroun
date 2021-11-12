<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }

    /** @test */
    function 사용자는_카테고리별_전문가_목록을_조회할_수_있다()
    {
        $categories = Category::factory()->count(2)->create();

        $mcWorkers = User::factory(["worker" => true])->count(6)->create();

        $studioWorkers = User::factory(["worker" => true])->count(7)->create();

        $commonUsers = User::factory(["worker" => false])->count(7)->create();

        foreach($mcWorkers as $mcWorker){
            $mcWorker->categories()->attach($categories[0]);
        }

        foreach($studioWorkers as $studioWorker){
            $studioWorker->categories()->attach($categories[1]);
        }

        foreach($commonUsers as $commonUser){
            $commonUser->categories()->attach($categories[1]);
        }

        // 카테고리1만 포함할 경우
        $category_ids = [];

        $category_ids[] = $categories[0]->id;

        $workers = $this->json("get","/api/workers", [
            "category_ids" => $category_ids,
        ])->decodeResponseJson("data")["data"];

        $this->assertCount(count($mcWorkers), $workers);


        // 카테고리2만 포함할 경우
        $category_ids = [];

        $category_ids[] = $categories[1]->id;

        $workers = $this->json("get","/api/workers", [
            "category_ids" => $category_ids,
        ])->decodeResponseJson("data")["data"];

        $this->assertCount(count($studioWorkers), $workers);


        // 카테고리1과 카테고리2 모두 포함할 경우
        $category_ids = [];

        $category_ids[] = $categories[0]->id;
        $category_ids[] = $categories[1]->id;

        $workers = $this->json("get","/api/workers", [
            "category_ids" => $category_ids,
        ])->decodeResponseJson("data")["data"];

        $this->assertCount(count($studioWorkers) + count($mcWorkers), $workers);
    }

    /** @test */
    function 사용자는_인기순_전문가_목록을_조회할_수_있다()
    {
        $workers = User::factory(["worker" => true])->count(6)->create();

        $workers = $this->json("get","/api/workers", [
            "orderBy" => "count_request",
        ])->decodeResponseJson("data")["data"];

        $prevWorker = null;

        foreach($workers as $worker){
            if($prevWorker)
                $this->assertTrue($prevWorker["count_request"] > $worker["count_request"]);

            $prevWorker = $worker;
        }
    }

    /** @test */
    function 사용자는_신규순_전문가_목록을_조회할_수_있다()
    {
        User::factory(["worker" => true, "created_at" => Carbon::now()])->create();
        User::factory(["worker" => true, "created_at" => Carbon::now()->subDays(3)])->create();
        User::factory(["worker" => true, "created_at" => Carbon::now()->addDays(3)])->create();

        $workers = $this->json("get","/api/workers", [
            "orderBy" => "created_at",
        ])->decodeResponseJson("data")["data"];

        $prevWorker = null;

        foreach($workers as $worker){
            if($prevWorker)
                $this->assertTrue($prevWorker["created_at"] > $worker["created_at"]);

            $prevWorker = $worker;
        }
    }

    /** @test */
    function 사용자는_이름에_검색키워드가_포함된_전문가_목록을_조회할_수_있다()
    {
        $word = "test";

        $includeWordWorkers = User::factory(["worker" => true, "name" => "123123123".$word."555"])->count(6)->create();
        $commonUsers = User::factory(["worker" => false, "name" => "123123123".$word."555"])->count(4)->create();
        $excludeWordWorkers = User::factory(["worker" => true, "name" => "123123123555"])->count(2)->create();

        $workers = $this->json("get","/api/workers", [
            "word" => $word,
        ])->decodeResponseJson("data")["data"];

        $this->assertCount(count($includeWordWorkers), $workers);

    }
}
