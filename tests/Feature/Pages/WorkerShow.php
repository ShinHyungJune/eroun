<?php

namespace Tests\Feature\Pages;

use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerShow extends TestCase
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
    function 사용자는_전문가상세페이지에서_전문가_정보를_볼_수_있다()
    {
        $worker = User::factory(["worker"=>true])->create();

        $this->get("/workers/".$worker->id)->assertInertia(function($page){
            $item = $page->toArray()["props"]["worker"];

            $this->assertNotEmpty($item);
        });
    }

    /** @test */
    function 사용자가_전문가상세페이지를_조회하면_해당_전문가의_조회수가_올라간다()
    {
        $worker = User::factory(["worker"=>true])->create();

        $this->get("/workers/".$worker->id)->assertInertia(function($page) use ($worker){
            $item = $page->toArray()["props"]["worker"]["data"];

            $this->assertEquals($worker->count_view + 1 , $item["count_view"]);
        });
    }

    /** @test */
    function 사용자가_전문가상세페이지를_조회하면_해당_전문가의_리뷰_목록을_확인할_수_있다()
    {
        $worker = User::factory(["worker"=>true])->create();

        $workerReviews = Review::factory()->count(5)->create([
            "worker_id" => $worker->id
        ]);

        $anotherReviews = Review::factory()->count(7)->create();

        $this->get("/workers/".$worker->id)->assertInertia(function($page) use ($workerReviews){
            $reviews = $page->toArray()["props"]["reviews"]["data"];

            $this->assertCount(count($workerReviews) , $reviews);
        });
    }

    /** @test */
    function 사용자는_전문가상세페이지에서_리뷰를_생성할_수_있다()
    {
        $worker = User::factory(["worker"=>true])->create();

        $form = [
            "worker_id" => $worker->id,
            "description" => "123123123"
        ];

        $this->post("/reviews", $form)->assertInertia(function($page){
            $review = $page->toArray()["props"]["review"]["data"];

            $this->assertNotEmpty($review);
        });
    }
}
