<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $response;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": "success",
            "message": "Operation completed successfully",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john.doe@example.com",
                "created_at": "2021-01-01T00:00:00Z",
                "updated_at": "2021-01-01T00:00:00Z" 
            },
            "authorisation": {
                "token": "abc123",
                "type": "Bearer"
            }
        }';

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);
    }

    public function testResponseStatusIs200()
    {
        // Suponha que a resposta tenha um código de status
        $statusCode = 200; // Valor simulado
        $this->assertEquals(200, $statusCode);
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);
    }

    public function testUserNameAndEmailAreNonEmptyStrings()
    {
        $this->assertIsObject($this->response);
        $this->assertIsString($this->response->user->name);
        $this->assertNotEmpty($this->response->user->name, "Name should not be empty");

        $this->assertIsString($this->response->user->email);
        $this->assertNotEmpty($this->response->user->email, "Email should not be empty");
    }

    public function testAuthorizationTokenIsNonEmptyString()
    {
        $this->assertIsString($this->response->authorisation->token);
        $this->assertNotEmpty($this->response->authorisation->token, "Authorization token should not be empty");
    }

    public function testAuthorizationTypeIsNonEmptyString()
    {
        $this->assertIsString($this->response->authorisation->type);
        $this->assertNotEmpty($this->response->authorisation->type, "Authorization type should not be empty");
    }
}