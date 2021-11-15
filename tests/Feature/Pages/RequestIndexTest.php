<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestIndexTest extends TestCase
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
    function 사용자는_자신의_섭외요청_목록을_조회할_수_있다()
    {
        $myRequests = Request::factory([
            "user_id" => $this->user->id
        ])->count(5)->create();

        $otherRequests = Request::factory()->count(4)->create();

        $this->get("/requests")->assertInertia(function($page) use($myRequests){
            $items = $page->toArray()["props"]["requests"]["data"];

            $this->assertCount(count($myRequests), $items);
        });
    }
}
