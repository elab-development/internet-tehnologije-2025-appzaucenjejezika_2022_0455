<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_courses_endpoint()
    {
        $user = User::updateOrCreate(
            ['email' => 'courses@test.com'],
            [
                'name' => 'Courses User',
                'password' => Hash::make('password123'),
            ]
        );

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200);
    }

    public function test_register_endpoint()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test',
            'email' => 'test' . time() . '@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
    }

    public function test_login_endpoint()
    {
        User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Test',
                'password' => Hash::make('password123'),
            ]
        );

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
    }
}