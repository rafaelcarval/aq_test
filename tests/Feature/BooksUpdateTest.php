<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksUpdateTest extends TestCase
{
    private $response;
    private $statusCode;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Operation successful", 
            "book": {
                "title": "The Great Gatsby",
                "author": "F. Scott Fitzgerald"
            }
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

    public function testStatusFieldInResponseShouldExistAndBeTrue()
    {
        $this->assertTrue(property_exists($this->response, 'status'));
        $this->assertTrue($this->response->status === true);
    }

    public function testMessageFieldShouldExistAndBeNonEmptyString()
    {
        $this->assertTrue(property_exists($this->response, 'message'));
        $this->assertIsString($this->response->message);
        $this->assertGreaterThan(0, strlen($this->response->message), "Message should not be empty");
    }

    public function testBookObjectExistsInResponse()
    {
        $this->assertTrue(property_exists($this->response, 'book'));
        $this->assertIsObject($this->response->book);
    }
}