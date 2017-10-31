<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class AuthTest
 *
 * @category Tests
 * @package  Tests\App\HTTP\Controllers
 */
class AuthTest extends TestCase
{
     /**
     * Test successful authentication
     */
    public function testAuthenticationSuccess()
    {
        $response = $this->firstSuccessfulLoginDetails();
        $response->seeJsonContains(['name'=>'Charles Oduk']);
        $response->assertResponseStatus(200);
    }
    
    /**
     * Test generation of tokens on successful login
     */
    public function testTokenGeneratedOnAuthenticationSuccess()
    {
        $this->secondSuccessfulLoginDetails();
        $this->assertResponseStatus(200);
        $response = json_decode($this->response->getContent());
        $this->assertObjectHasAttribute('token', $response);
    }

    /**
     * Test authentication fails when credentials are incorrect
     */
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
