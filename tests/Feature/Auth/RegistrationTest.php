<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'prenom' => 'Test',
            'nom' => 'User',
            'email' => 'test@example.com',
            'telephone' => '775678901',
            'adresse' => 'Dakar',
            'password' => 'password',
            'password_confirmation' => 'password',
            'communaute_nom' => 'Test Communaute',
            'communaute_description' => 'Test Description',
        ]);

        $response->assertRedirect(route('login'));
    }
}
