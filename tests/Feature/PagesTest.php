<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\TurnipQueue;
use App\User;
use Str;

class PagesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicPages()
    {
        // Home Page
        $response = $this->get('/');
        $response->assertStatus(200);

        // Queue Search Page
        $response = $this->get('/queue');
        $response->assertStatus(200);

        // Terms and Conditions Page
        $response = $this->get('/terms-and-conditions');
        $response->assertStatus(200);

        // Donation Page
        $response = $this->get('/donate');
        $response->assertStatus(200);

        // Donation Gratitude Page
        $response = $this->get('/donate/thank-you');
        $response->assertStatus(200);

        // Login Page
        $response = $this->get('/login');
        $response->assertStatus(200);

        // Register Page
        $response = $this->get('/register');
        $response->assertStatus(200);

        // Password Reset Page
        $response = $this->get('/password/reset');
        $response->assertStatus(200);
    }

    /**
     * Test that the 'join Queue' page loads.
     *
     * @return void
     */
    public function testJoinQueuePage()
    {
        $user = factory(User::class)->create();

        // Generate a token
        do {
            $token = (string) Str::uuid();
        } while (TurnipQueue::where("token", "=", $token)->first() instanceof TurnipQueue);

        $turnipQueue = TurnipQueue::create([
            'user_id' => $user->id,
            'token' => $token,
            'dodo_code' => 'AAAAA',
            'expires_at' => now()->addHours(3),
            'concurrent_visitors' => 3,
            'custom_question' => 'What is love?',
        ]);

        // Test that the 'join queue' page loads
        $response = $this->get('/queue/' . $token);
        $response->assertStatus(200);

        $turnipQueue->forceDelete();
        $user->delete();
    }
}
