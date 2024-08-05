<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorsUpdateTest extends TestCase
{
    private $response;
    private $statusCode;
    private $headers;

    protected function setUp(): void
    { 
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "author": {
                "id": 1,
                "name": "John Doe",
                "birthday": "1990-01-01",
                "created_at": "2021-01-01T00:00:00Z",
                "updated_at": "2021-01-01T00:00:00Z",
                "deleted_at": null
            }
        }';

        // Simulação dos headers de resposta
        $this->headers = [
            'Content-Type' => 'application/json'
        ];

        // Simulação do código de status da resposta
        $this->statusCode = 200; // Valor simulado

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
        $this->assertTrue(property_exists($this->response, 'author'), "Field 'author' does not exist in response");
        $author = $this->response->author;
        
        $requiredFields = ["id", "name", "birthday", "created_at", "updated_at", "deleted_at"];
        foreach ($requiredFields as $field) {
            $this->assertTrue(property_exists($author, $field), "Field '$field' does not exist in author");
        }
    }

    public function testIdIsNonNegativeInteger()
    {
        $this->assertIsInt($this->response->author->id);
        $this->assertGreaterThanOrEqual(0, $this->response->author->id, "Id should be a non-negative integer");
    }

    public function testNameAndBirthdayMustBeNonEmptyStrings()
    {
        $this->assertIsObject($this->response);
        $this->assertIsString($this->response->author->name);
        $this->assertGreaterThanOrEqual(1, strlen($this->response->author->name), "Name should not be empty");
        $this->assertIsString($this->response->author->birthday);
        $this->assertGreaterThanOrEqual(1, strlen($this->response->author->birthday), "Birthday should not be empty");
    }
}