<?php

namespace Tests\Feature\Pages;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkerIndexTest extends TestCase
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
            $total = $page->toArray()["props"]["workers"]["meta"]["total"];

            $this->assertEquals(count($workers), $total);
        });
    }

    /** @test */
    function 사용자는_전문가페이지에서_전문가_목록을_볼_수_있다()
    {
        $workers = User::factory(["worker" => true])->count(8)->create();

        $commonUsers = User::factory(["worker" => false])->count(10)->create();

        $this->get("/workers")->assertInertia(function($page) use ($workers){
            $items = $page->toArray()["props"]["workers"]["data"];

            $this->assertCount(count($workers), $items);
        });
    }

    /** @test */
    function 여러카테고리를_포함하는_전문가_목록을_볼_수_있다()
    {
        $categories = Category::factory()->count(3)->create();

        $workers = User::factory(["worker" => true])->count(8)->create();

        $workers[0]->categories()->attach($categories[0]);
        $workers[1]->categories()->attach($categories[1]);
        $workers[2]->categories()->attach($categories[1]);

        $filterCategories = [];

        $filterCategories[] = $categories[0]->id;

        $this->json("get","/workers", [
            "category_ids" => $filterCategories
        ])->assertInertia(function($page) use ($workers){
            $items = $page->toArray()["props"]["workers"]["data"];

            $this->assertCount(1, $items);
            $this->assertEquals($items[0]["id"], $workers[0]->id);
        });

        $filterCategories[] = $categories[1]->id;

        $this->json("get","/workers", [
            "category_ids" => $filterCategories
        ])->assertInertia(function($page) use ($workers){
            $items = $page->toArray()["props"]["workers"]["data"];

            $this->assertCount(3, $items);
        });

        $filterCategories = [];

        $this->json("get","/workers", [
            "category_ids" => $filterCategories
        ])->assertInertia(function($page) use ($workers){
            $items = $page->toArray()["props"]["workers"]["data"];

            $this->assertCount(count($workers), $items);
        });
    }

    /** @test */
    function 이름에_특정단어를_포함하는_전문가_목록을_볼_수_있다()
    {
        $word = "123";

        $includeWorkers = User::factory(["worker" => true, "name" => "test".$word."444"])->count(8)->create();

        $excludeWorkers = User::factory(["worker" => true])->count(6)->create();

        $commonUsers = User::factory(["worker" => false])->count(10)->create();

        $this->json("get", "/workers", [
            "word" => $word
        ])->assertInertia(function($page) use ($includeWorkers){
            $items = $page->toArray()["props"]["workers"]["data"];

            $this->assertCount(count($includeWorkers), $items);
        });
    }
}
