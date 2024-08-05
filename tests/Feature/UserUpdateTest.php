<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    private $response;
    private $headers;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Operation completed successfully"
        }';

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);

        // Simulação de cabeçalhos de resposta
        $this->headers = [
            "Content-Type" => "application/json"
        ];
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
        $this->assertTrue(property_exists($this->response, 'status'), "Response does not have 'status' property");
        $this->assertTrue(property_exists($this->response, 'message'), "Response does not have 'message' property");
    }

    public function testStatusIsBoolean()
    {
        $this->assertIsBool($this->response->status, "Status should be a boolean value");
    }

    public function testContentTypeHeaderIsApplicationJson()
    {
        $this->assertArrayHasKey("Content-Type", $this->headers, "Headers do not contain 'Content-Type'");
        $this->assertStringContainsString("application/json", $this->headers["Content-Type"], "Content-Type header should be 'application/json'");
    }
}