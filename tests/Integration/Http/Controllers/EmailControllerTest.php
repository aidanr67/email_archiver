<?php

namespace Integration\Http\Controllers;

use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class EmailControllerTest
 *
 * @coversDefaultClass \App\Http\Controllers\EmailController
 *
 * @small
 */
class EmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the index route.
     *
     * @test
     */
    public function testIndex()
    {
        $emails = Email::factory()->count(5)->create();

        $response = $this->get(route('emails.index'));

        $response->assertStatus(200)
            ->assertViewIs('emails.email_listing')
            ->assertViewHas('emails', $emails);
    }

    /**
     * Tests the show route.
     *
     * @test
     */
    public function testShow()
    {
        $email = Email::factory()->create();

        $response = $this->get(route('emails.show', ['email' => $email]));

        $response->assertStatus(200)
            ->assertViewIs('emails.email')
            ->assertViewHas('email', $email);
    }
}
