<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login_a_user_with_employee_id_and_password()
    {
        // Create a user in the database with known credentials
        $user = User::factory()->create([
            'employee_id' => '12345',
            'password' => bcrypt('password123'), // Ensure password is hashed
        ]);

        // Prepare login data
        $loginData = [
            'employee_id' => '12345',
            'password' => 'password123',
        ];

        // Make a POST request to the login endpoint
        $response = $this->postJson(route('login'), $loginData);

        // Assert the response status is 200 OK
        $response->assertStatus(200);

        // Assert the response contains a token (if applicable)
        $this->assertArrayHasKey('token', $response->json());

        // Optionally, assert the user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_returns_error_for_invalid_credentials()
    {
        // Prepare login data with invalid credentials
        $loginData = [
            'employee_id' => 'INVALID_EMP',
            'password' => 'wrongpassword',
        ];

        // Make a POST request to the login endpoint
        $response = $this->postJson(route('login'), $loginData);

        // Assert the response status is 401 Unauthorized
        $response->assertStatus(401);

        // Assert the response contains the expected error message
        $response->assertJson(['message' => 'Unauthorized']);
    }
}
