<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthenticationSuccess()
    {
        $response = $this->firstSuccessfulLoginDetails();
        $response->seeJsonContains(['name'=>'Charles Oduk']);
        $response->assertResponseStatus(200);
    }
    
    public function testTokenGeneratedOnAuthenticationSuccess()
    {
        $response = $this->post('api/v1/auth/login', [
            'email'=>'oduk@andela.com', 'password'=>'password'
            ]
        );

        $this->seeJsonStructure([
            'token'
        ]);
    }
    public function testAuthenticationFailsWithWrongCredentials()
    {
        $response = $this->post('api/v1/auth/login', [
            'email'=>'unknown@andela.com', 'password'=>'password'
            ]
        );
        $response->seeJsonContains(["user_not_found"]);
        $response->assertResponseStatus(404);
    }
}