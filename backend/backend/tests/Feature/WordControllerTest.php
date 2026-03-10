<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_courses(): void
    {
        $user = User::factory()->create();
        Course::factory()->count(3)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/courses');

        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_fetch_courses(): void
    {
        $response = $this->getJson('/api/courses');

        $response->assertStatus(401);
    }
}