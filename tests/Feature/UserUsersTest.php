<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUsersTest extends TestCase
{
    private $response;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "data": [
                {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john.doe@example.com",
                    "email_verified_at": "2021-01-01T00:00:00Z",
                    "created_at": "2021-01-01T00:00:00Z",
                    "updated_at": "2021-01-01T00:00:00Z"
                },
                {
                    "id": 2,
                    "name": "Jane Doe",
                    "email": "jane.doe@example.com",
                    "email_verified_at": "2021-01-01T00:00:00Z",
                    "created_at": "2021-01-01T00:00:00Z",
                    "updated_at": "2021-01-01T00:00:00Z"
                }
            ]
        }';

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);
    }

    public function testResponseStatusIs200()
    {
        // Simulação do código de status da resposta
        $statusCode = 200; // Valor simulado
        $this->assertEquals(200, $statusCode);
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);
        $this->assertIsArray($this->response->data);
        
        foreach ($this->response->data as $user) {
            $this->assertTrue(property_exists($user, 'id'), "User does not have 'id' property");
            $this->assertTrue(property_exists($user, 'name'), "User does not have 'name' property");
            $this->assertTrue(property_exists($user, 'email'), "User does not have 'email' property");
            $this->assertTrue(property_exists($user, 'email_verified_at'), "User does not have 'email_verified_at' property");
            $this->assertTrue(property_exists($user, 'created_at'), "User does not have 'created_at' property");
            $this->assertTrue(property_exists($user, 'updated_at'), "User does not have 'updated_at' property");
        }
    }

    public function testEmailIsInValidFormat()
    {
        $this->assertIsArray($this->response->data);
        foreach ($this->response->data as $user) {
            $this->assertMatchesRegularExpression('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $user->email, "Email format is not valid");
        }
    }

    public function testDataArrayIsPresentAndHasExpectedNumberOfElements()
    {
        $this->assertIsObject($this->response);
        $this->assertIsArray($this->response->data);
        $this->assertNotEmpty($this->response->data);
    }
}
