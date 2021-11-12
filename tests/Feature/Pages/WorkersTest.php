<?php

namespace Tests\Feature\Pages;

use App\Models\Category;
use App\Models\User;
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
    function 사용자는_전문가페이지에서_카테고리_목록을_볼_수_있다()
    {
        $categories = Category::factory()->count(10)->create();

        $this->get("/workers")->assertInertia(function($page) use ($categories){
            $items = $page->toArray()["props"]["categories"]["data"];

            $this->assertCount(count($categories), $items);
        });
    }

    /** @test */
    function 사용자는_전문가페이지에서_전체_전문가수를_볼_수_있다()
    {
        $workers = User::factory(["worker" => true])->count(100)->create();

        $commonUsers = User::factory(["worker" => false])->count(10)->create();

        $this->get("/workers")->assertInertia(function($page) use ($workers){
            $total = $page->toArray()["props"]["populatedWorkers"]["meta"]["total"];

            $this->assertEquals(count($workers), $total);
        });
    }

    /** @test */
    function 사용자는_전문가페이지에서_전문가_목록을_볼_수_있다()
    {
        $workers = User::factory(["worker" => true])->count(8)->create();

        $commonUsers = User::factory(["worker" => false])->count(10)->create();

        $this->get("/workers")->assertInertia(function($page) use ($workers){
            $items = $page->toArray()["props"]["populatedWorkers"]["data"];

            $this->assertCount(count($workers), $items);
        });
    }
}
