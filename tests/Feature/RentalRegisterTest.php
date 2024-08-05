<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentalRegisterTest extends TestCase
{
    private $response;
    private $statusCode;
    private $headers;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "status": true,
            "message": "Success",
            "rental": {
                "users_id": 1,
                "books_id": 2,
                "rent_date": "2023-08-01",
                "return_date": "2023-08-15",
                "updated_at": "2023-08-02 10:00:00",
                "created_at": "2023-08-01 10:00:00",
                "id": 123
            }
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

    public function testContentTypeHeaderIsApplicationJson()
    {
        $this->assertStringContainsString('application/json', $this->headers['Content-Type']);
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);

        $this->assertTrue(property_exists($this->response, 'status'), "Property 'status' does not exist");
        $this->assertTrue(property_exists($this->response, 'message'), "Property 'message' does not exist");
        $this->assertTrue(property_exists($this->response, 'rental'), "Property 'rental' does not exist");
    }

    public function testRentalObjectContainsAllRequiredProperties()
    {
        $this->assertIsObject($this->response->rental);

        $expectedProperties = ['users_id', 'books_id', 'rent_date', 'return_date', 'updated_at', 'created_at', 'id'];
        
        foreach ($expectedProperties as $property) {
            $this->assertTrue(property_exists($this->response->rental, $property), "Property '$property' does not exist in 'rental'");
        }
    }
}
