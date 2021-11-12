<?php

namespace Tests\Feature\Pages;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Event;
use App\Models\Request;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
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
    public function 사용자는_메인페이지에서_공개된_배너_목록을_조회할_수_있다()
    {
        $secretBanners = Banner::factory(["secret" => true])->count(10)->create();

        $publicBanners = Banner::factory(["secret" => false])->count(7)->create();

        $this->get("/")->assertInertia(function($page) use ($publicBanners){
            $items = $page->toArray()["props"]["banners"]["data"];

            $this->assertCount(count($publicBanners), $items);
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_카테고리_목록을_조회할_수_있다()
    {
        $categories = Category::factory()->count(10)->create();

        $this->get("/")->assertInertia(function($page) use ($categories){
            $items = $page->toArray()["props"]["categories"]["data"];

            $this->assertCount(count($categories), $items);
        });
    }

    /** @test */
    public function 사용자는_전문가가_가진_카테고리를_알_수_있다()
    {
        $categories = ["테스트1", "테스트2"];

        $worker = User::factory()->create(["worker" => true]);

        foreach($categories as $category){
            $worker->categories()->create([
                "title" => $category
            ]);
        }

        $this->get("/")->assertInertia(function($page) use ($categories){
            $items = $page->toArray()["props"]["populatedWorkers"]["data"];

            $this->assertNotEmpty($items);

            foreach($items as $item){
                $this->assertCount(count($categories), $item["categories"]);
            }
        });
    }

    /** @test */
    public function 사용자는_전문가가_가진_리뷰평점을_알_수_있다()
    {
        $scores = [0, 4, 5];

        $worker = User::factory()->create(["worker" => true]);

        foreach($scores as $score){
            Review::factory()->create(["worker_id" => $worker->id, "score" => $score]);
        }

        $this->get("/")->assertInertia(function($page) use ($scores){

            $items = $page->toArray()["props"]["populatedWorkers"]["data"];

            $this->assertNotEmpty($items);

            foreach($items as $item){
                // 아직 리뷰 못받은 전문가는 평점 NULL
                if($item["score"]){
                    $this->assertEquals(array_sum($scores) / count($scores), $item["score"]);
                }
            }
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_인기_전문가_목록을_조회할_수_있다()
    {
        $populatedWorkers = User::factory(["worker" => true])->count(4)->create();

        $this->get("/")->assertInertia(function($page){
            $items = $page->toArray()["props"]["populatedWorkers"]["data"];

            $this->assertNotEmpty($items);

            $prevItem = null;

            foreach($items as $item){
                if($prevItem)
                    $this->assertTrue($item["count_request"] >= $item["count_request"]);

                $prevItem = $item;
            }
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_최근_활동한_전문가_목록을_조회할_수_있다()
    {
        User::factory(["updated_at" => Carbon::now()])->create(["worker" => true]);
        User::factory(["updated_at" => Carbon::now()->subDays(2)])->create(["worker" => true]);
        User::factory(["updated_at" => Carbon::now()->subDays(1)])->create(["worker" => true]);
        User::factory(["updated_at" => Carbon::now()->addDay(1)])->create(["worker" => true]);

        $this->get("/")->assertInertia(function($page){
            $items = $page->toArray()["props"]["recentWorkers"]["data"];

            $this->assertNotEmpty($items);

            $prevItem = null;

            foreach($items as $item){
                if($prevItem)
                    $this->assertTrue($item["updated_at"] >= $item["updated_at"]);

                $prevItem = $item;
            }
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_신규_전문가_목록을_조회할_수_있다()
    {
        User::factory(["created_at" => Carbon::now()])->create(["worker" => true]);
        User::factory(["created_at" => Carbon::now()->subDays(2)])->create(["worker" => true]);
        User::factory(["created_at" => Carbon::now()->subDays(1)])->create(["worker" => true]);
        User::factory(["created_at" => Carbon::now()->addDay(1)])->create(["worker" => true]);

        $this->get("/")->assertInertia(function($page){
            $items = $page->toArray()["props"]["newWorkers"]["data"];

            $this->assertNotEmpty($items);

            $prevItem = null;

            foreach($items as $item){
                if($prevItem)
                    $this->assertTrue($item["created_at"] >= $item["created_at"]);

                $prevItem = $item;
            }
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_등록된_전문가수와_누적의뢰수를_확인할_수_있다()
    {
        $workers = User::factory(["worker" => true])->count(4)->create();
        $commonUsers = User::factory(["worker" => false])->count(7)->create();
        $requests = Request::factory()->count(11)->create();

        $this->get("/")->assertInertia(function($page) use ($workers, $requests){
            $counts = $page->toArray()["props"]["counts"];

            $this->assertEquals(count($workers), $counts["workers"]);
            $this->assertEquals(count($requests), $counts["requests"]);
        });
    }

    /** @test */
    public function 사용자는_메인페이지에서_이벤트_목록을_조회할_수_있다()
    {
        $events = Event::factory()->count(5)->create();

        $this->get("/")->assertInertia(function($page) use ($events){
            $items = $page->toArray()["props"]["events"]["data"];

            $this->assertCount(count($events), $items);
        });
    }
}
