<?php

declare(strict_types=1);

namespace Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;

final class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserRegisterSuccess(): void
    {
        $response = $this->postJson(route('user.create'), [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();
        $this->assertSame([], $response->json());
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
        ]);
    }

    public function testUserShowSuccess(): void
    {
        $now = Carbon::now();

        $user = User::factory()->create([
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $response = $this->getJson(route('user.show', ['user' => $user]));

        $response->assertSuccessful();
        $this->assertSame(
            [
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                ],
            ],
            $response->json()
        );
    }

    public function testUserListSuccess(): void
    {
        $now = Carbon::now();

        $user1 = User::factory()->create([
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $user2 = User::factory()->create([
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $user3 = User::factory()->create([
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $response = $this->getJson(route('user.list'));

        $response->assertSuccessful();

        $this->assertSame(
            [
                'data' => [
                    [
                        'id' => $user1->id,
                        'name' => $user1->name,
                        'email' => $user1->email,
                        'created_at' => $user1->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $user1->updated_at->format('Y-m-d H:i:s'),
                    ],
                    [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                        'created_at' => $user2->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $user2->updated_at->format('Y-m-d H:i:s'),
                    ],
                    [
                        'id' => $user3->id,
                        'name' => $user3->name,
                        'email' => $user3->email,
                        'created_at' => $user3->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $user3->updated_at->format('Y-m-d H:i:s'),
                    ],
                ],
                'links' => [
                    'first' => route('user.list', ['page' => 1]),
                    'last' => null,
                    'prev' => null,
                    'next' => null,
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'path' => route('user.list'),
                    'per_page' => 10,
                    'to' => 3,
                ],
            ],
            $response->json()
        );
    }
}
