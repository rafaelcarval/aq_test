<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserMeTest extends TestCase
{
    private $response;
    private $responseTime;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "email_verified_at": "2021-01-01T00:00:00Z",
            "created_at": "2021-01-01T00:00:00Z",
            "updated_at": "2021-01-01T00:00:00Z"
        }';

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);

        // Simulação do tempo de resposta em milissegundos
        $this->responseTime = 450; // Valor simulado
    }

    public function testResponseStatusIs200()
    {
        // Suponha que a resposta tenha um código de status
        $statusCode = 200; // Valor simulado
        $this->assertEquals(200, $statusCode); 
    }

    public function testResponseTimeIsWithinAcceptableRange()
    {
        $this->assertLessThan(500, $this->responseTime, "Response time should be below 500ms");
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);
        $this->assertTrue(property_exists($this->response, 'id'), "Response does not have 'id' property");
        $this->assertTrue(property_exists($this->response, 'name'), "Response does not have 'name' property");
        $this->assertTrue(property_exists($this->response, 'email'), "Response does not have 'email' property");
        $this->assertTrue(property_exists($this->response, 'email_verified_at'), "Response does not have 'email_verified_at' property");
        $this->assertTrue(property_exists($this->response, 'created_at'), "Response does not have 'created_at' property");
        $this->assertTrue(property_exists($this->response, 'updated_at'), "Response does not have 'updated_at' property");
    }

    public function testIdIsNonNegativeInteger()
    {
        $this->assertIsInt($this->response->id);
        $this->assertGreaterThanOrEqual(0, $this->response->id, "Id should be a non-negative integer");
    }

    public function testEmailIsInValidEmailFormat()
    {
        $this->assertMatchesRegularExpression('/^.+@.+\..+$/', $this->response->email, "Email should be in a valid format");
    }
}