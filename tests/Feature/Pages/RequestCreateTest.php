<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use App\Models\VerifyNumber;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RequestCreateTest extends TestCase
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
    function 게스트는_인증된_폰번호로만_섭외요청을_생성할_수_있다()
    {
        Auth::logout();

        $form = [
            "contact" => null,
            "category" => "123",
            "time" => "123",
            "address" => "123",
            "price" => "123",
            "style" => "123",
            "comment" => "123",
            "required_at" => Carbon::now()->toJSON(),
        ];

        $invalidContact = "123";

        $validContact = "010-1234-1234";

        VerifyNumber::factory()->create([
            "contact" => $validContact,
            "verified" => true
        ]);

        // 미인증 폰번호
        $form["contact"] = $invalidContact;

        $this->post("/requests", $form)->assertStatus(302);


        // 인증 폰번호
        $form["contact"] = $validContact;

        $this->post("/requests", $form);


        $this->assertCount(1, Request::all());
    }

    /** @test */
    function 사용자의_연락처가_비어있으면_계정정보_업데이트페이지로_이동한다()
    {
        $this->user->update(["contact" => null]);

        $form = [
            "contact" => null,
            "category" => "123",
            "time" => "123",
            "address" => "123",
            "price" => "123",
            "style" => "123",
            "comment" => "123",
            "required_at" => Carbon::now()->toJSON(),
        ];

        $this->post("/requests", $form)->assertInertia(function ($page) {
            $page->component("Users/Update");
        });
    }

    /** @test */
    function 사용자가_섭외요청을_생성하면_자동으로_연락처가_등록된다()
    {
        $this->user->update(["contact" => "123"]);

        $form = [
            "contact" => null,
            "category" => "123",
            "time" => "123",
            "address" => "123",
            "price" => "123",
            "style" => "123",
            "comment" => "123",
            "required_at" => Carbon::now()->toJSON(),
        ];

        $this->post("/requests", $form);

        $request = Request::first();

        $this->assertEquals($request->contact, $this->user->contact);
    }

    /** @test */
    function 존재하지_않는_전문가에게_섭외요청을_생성할_수_없다()
    {
        $form = [
            "worker_id" => 154,
            "contact" => null,
            "category" => "123",
            "time" => "123",
            "address" => "123",
            "price" => "123",
            "style" => "123",
            "comment" => "123",
            "required_at" => Carbon::now()->toJSON(),
        ];

        $this->post("/requests", $form);

        $this->assertCount(0, Request::all());


        $worker = User::factory()->create([
            "worker" => true
        ]);

        $form["worker_id"] = $worker->id;

        $this->post("/requests", $form);

        $this->assertCount(1, Request::all());
    }
}
