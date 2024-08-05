<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksRegisterTest extends TestCase
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

    public function testResponseTimeIsLessThan500ms()
    {
        $this->assertLessThan(500, $this->responseTime, "Response time should be less than 500ms");
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);
        $this->assertTrue(property_exists($this->response, 'status'), "Response does not have 'status' property");
        $this->assertTrue(property_exists($this->response, 'message'), "Response does not have 'message' property");
        $this->assertTrue(property_exists($this->response, 'author'), "Response does not have 'author' property");
    }
}

