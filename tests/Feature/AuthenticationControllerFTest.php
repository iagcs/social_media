<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthenticationControllerFTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'password')
        ]);

        $userLogin = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->post('/api/login', $userLogin);

        $this->assertAuthenticatedAs($user);

        $response->assertStatus(Response::HTTP_OK);
    }

   public function test_register_success()
   {
        $userLogin = [
            'name'      => "iago",
            'email'     =>  "iago@gmail.com",
            'password'  => 'password',
        ];

        $response = $this->post('/api/register', $userLogin);

        $response->assertJson([
            "mensagem" => "Registrado com sucesso."
        ]);

        $this->assertDatabaseHas('users', [
            'name'      => "iago",
            'email'     =>  "iago@gmail.com",
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
   }
}
