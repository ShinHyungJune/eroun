<?php

namespace Tests\Feature\Pages;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventIndexTest extends TestCase
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
    function 누구나_일반인용_이벤트_목록을_조회할_수_있다()
    {
        $workerEvents = Event::factory(["worker" => true])->count(6)->create();

        $commonEvents = Event::factory(["worker" => false])->count(6)->create();

        $this->get("/events")->assertInertia(function($page) use ($commonEvents){
            $items = $page->toArray()["props"]["events"]["data"];

            $this->assertCount(count($commonEvents), $items);
        });
    }


    /** @test */
    function 전문가는_전문가용_이벤트_목록을_조회할_수_있다()
    {
        $worker = User::factory()->create(["worker" => true]);

        $this->actingAs($worker);

        $workerEvents = Event::factory(["worker" => true])->count(4)->create();

        $commonEvents = Event::factory(["worker" => false])->count(6)->create();

        $this->json("get","/events", [
            "worker" => true
        ])->assertInertia(function($page) use ($workerEvents){
            $items = $page->toArray()["props"]["events"]["data"];

            $this->assertCount(count($workerEvents), $items);
        });
    }

    /** @test */
    function 인기순_이벤트_목록을_조회할_수_있다()
    {
        $events = Event::factory()->count(6)->create();

        $this->json("get","/events", [
            "orderBy" => "count_view"
        ])->assertInertia(function($page){
            $items = $page->toArray()["props"]["events"]["data"];

            $prevItem = null;

            foreach($items as $item){
                if($prevItem)
                    $this->assertTrue($prevItem["count_view"] > $item["count_view"]);

                $prevItem = $item;
            }
        });
    }

    /** @test */
    function 신규순_이벤트_목록을_조회할_수_있다()
    {
        Event::factory()->create(["created_at" => Carbon::now()]);
        Event::factory()->create(["created_at" => Carbon::now()->subDays(2)]);
        Event::factory()->create(["created_at" => Carbon::now()->addDays(2)]);

        $this->json("get","/events", [
            "orderBy" => "created_at"
        ])->assertInertia(function($page){
            $items = $page->toArray()["props"]["events"]["data"];

            $prevItem = null;

            foreach($items as $item){
                if($prevItem)
                    $this->assertTrue($prevItem["created_at"] > $item["created_at"]);

                $prevItem = $item;
            }
        });
    }

    /** @test */
    function 누구나_이름에_검색키워드가_포함된_이벤트_목록을_조회할_수_있다()
    {
        $word = "test";

        $includeEvents = Event::factory(["title" => "123123123".$word."555"])->count(6)->create();
        $excludeEvents = Event::factory(["title" => "123123123555"])->count(2)->create();

        $this->json("get", "/events", [
            "word" => $word
        ])->assertInertia(function($page) use ($includeEvents){
            $items = $page->toArray()["props"]["events"]["data"];

            $this->assertCount(count($includeEvents), $items);
        });
    }
}
