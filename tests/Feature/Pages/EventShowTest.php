<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventShowTest extends TestCase
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
    function 누구나_이벤트상세페이지에서_이벤트_정보를_볼_수_있다()
    {
        $event = Event::factory()->create();

        $this->get("/events/".$event->id)->assertInertia(function($page){
            $item = $page->toArray()["props"]["event"];

            $this->assertNotEmpty($item);
        });
    }

    /** @test */
    function 누구나_이벤트상세페이지를_조회하면_해당_이벤트_조회수가_올라간다()
    {
        $event = Event::factory()->create();

        $this->get("/events/".$event->id)->assertInertia(function($page) use ($event){
            $item = $page->toArray()["props"]["event"]["data"];

            $this->assertEquals($event->count_view + 1 , $item["count_view"]);
        });
    }

    /** @test */
    function 전문가만_전문가이벤트상세페이지를_조회할_수_있다()
    {
        $event = Event::factory(["worker" => true])->create();

        $this->get("/events/".$event->id)->assertInertia(function($page){
            $page->component("Errors/403");
        });
    }
}
