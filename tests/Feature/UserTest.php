<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    private function getCurrentUser(): TestResponse
    {
        return $this->get('/users/current');
    }

    public function test_empty_array_is_returned_when_user_is_not_logged_in(): void
    {
        $response = $this->getCurrentUser();

        $response->assertOk();
        $response->assertJson([]);
    }

    public function test_current_user_can_be_returned(): void
    {
        $this->actingAs($this->user);

        $response = $this->getCurrentUser();

        $response->assertOk();
        $response->assertJson([
            'avatar' => $this->user->getAvatar(),
            'email' => $this->user->email,
            'isAdmin' => $this->user->is_admin,
            'name' => $this->user->name,
        ]);
    }
}
