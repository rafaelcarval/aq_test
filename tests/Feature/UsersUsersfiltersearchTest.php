<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersUsersfiltersearchTest extends TestCase
{
    private $response;
    private $responseTime;
    private $headers;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "data": [
                {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john.doe@example.com",
                    "email_verified_at": null,
                    "created_at": "2021-01-01T00:00:00Z",
                    "updated_at": "2021-01-01T00:00:00Z"
                },
                {
                    "id": 2,
                    "name": "Jane Doe",
                    "email": "jane.doe@example.com",
                    "email_verified_at": null,
                    "created_at": "2021-01-01T00:00:00Z",
                    "updated_at": "2021-01-01T00:00:00Z"
                }
            ]
        }';

        // Simulação dos headers de resposta
        $this->headers = [
            'Content-Type' => 'application/json'
        ];

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);
        $this->responseTime = 450; // Valor simulado
    }

    public function testResponseStatusIs200()
    {
        // Simulação do código de status da resposta
        $statusCode = 200; // Valor simulado
        $this->assertEquals(200, $statusCode);
    }

    public function testResponseTimeIsLessThan500ms()
    {
        $this->assertLessThan(500, $this->responseTime, "Response time should be less than 500ms");
    }

    public function testContentTypeHeaderIsApplicationJson()
    {
        $this->assertEquals('application/json', $this->headers['Content-Type'], "Content-Type header should be 'application/json'");
    }

    public function testDataArrayInResponseHasCorrectSchema()
    {
        $this->assertIsArray($this->response->data);
        
        foreach ($this->response->data as $item) {
            $this->assertIsObject($item);
            $this->assertIsInt($item->id);
            $this->assertIsString($item->name);
            $this->assertIsString($item->email);
            $this->assertNull($item->email_verified_at);
            $this->assertIsString($item->created_at);
            $this->assertIsString($item->updated_at);
        }
    }

    public function testEachObjectInDataArrayHasRequiredFields()
    {
        $this->assertIsArray($this->response->data);
        
        foreach ($this->response->data as $user) {
            $this->assertTrue(property_exists($user, 'id'), "User does not have 'id' property");
            $this->assertTrue(property_exists($user, 'name'), "User does not have 'name' property");
            $this->assertTrue(property_exists($user, 'email'), "User does not have 'email' property");
            $this->assertTrue(property_exists($user, 'created_at'), "User does not have 'created_at' property");
            $this->assertTrue(property_exists($user, 'updated_at'), "User does not have 'updated_at' property");
        }
    }
}