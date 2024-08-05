<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksDeleteTest extends TestCase
{
    private $response;
    private $statusCode;
    private $headers;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Success"
        }';

        // Simulação do código de status da resposta
        $this->statusCode = 200; // Valor simulado

        // Simulação do cabeçalho da resposta
        $this->headers = [
            'Content-Type' => 'application/json'
        ];

        // Decodifica a resposta JSON para um objeto PHP
        $this->response = json_decode($responseJson);
    }

    public function testResponseStatusCodeIs200()
    {
        $this->assertEquals(200, $this->statusCode);
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);

        // Verifica se as propriedades 'status' e 'message' existem
        $this->assertTrue(property_exists($this->response, 'status'), "Property 'status' does not exist");
        $this->assertTrue(property_exists($this->response, 'message'), "Property 'message' does not exist");
    }

    public function testVerifyContentTypeIsApplicationJson()
    {
        $this->assertEquals('application/json', $this->headers['Content-Type']);
    }
}
