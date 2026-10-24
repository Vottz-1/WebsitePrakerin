<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function test_it_redirects_to_login_when_auth_user_is_invalid(): void
    {
        Auth::shouldReceive('user')->once()->andReturn(new class {});

        $response = (new DashboardController())->index();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('login'), $response->getTargetUrl());
    }
}
