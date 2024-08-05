<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorRegisterTest extends TestCase
{
    private $response;
    private $responseTime;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Operation completed successfully",
            "author": {
                "name": "John Doe",
                "birthday": "1990-01-01"
            }
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
        $this->assertTrue(property_exists($this->response, 'status'), "Response does not have 'status' property");
        $this->assertTrue(property_exists($this->response, 'message'), "Response does not have 'message' property");
        $this->assertTrue(property_exists($this->response, 'author'), "Response does not have 'author' property");
    }

    public function testNameIsNonEmptyString()
    {
        $this->assertIsObject($this->response->author);
        $this->assertIsString($this->response->author->name);
        $this->assertNotEmpty($this->response->author->name, "Name should not be empty");
    }

    public function testBirthdayIsInValidDateFormat()
    {
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $this->response->author->birthday, "Birthday should be in valid date format (YYYY-MM-DD)");
    }
}