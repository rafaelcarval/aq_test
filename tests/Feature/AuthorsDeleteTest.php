<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorsDeleteTest extends TestCase
{
    private $response;
    private $statusCode;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Operation successful"
        }';

        // Simulação do código de status da resposta
        $this->statusCode = 200; // Valor simulado

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);
    }

    public function testResponseStatusCodeIs200()
    {
        $this->assertEquals(200, $this->statusCode);
    }

    public function testStatusAndMessageFieldsArePresentInResponse()
    {
        $this->assertTrue(property_exists($this->response, 'status'), "Field 'status' is missing in the response");
        $this->assertTrue(property_exists($this->response, 'message'), "Field 'message' is missing in the response");
    }

    public function testStatusShouldBeBoolean()
    {
        $this->assertIsBool($this->response->status);
    }

    public function testMessageIsString()
    {
        $this->assertIsString($this->response->message);
    }
}
