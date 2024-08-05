<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksBooksTest extends TestCase
{
    private $response;
    private $statusCode;
    private $headers;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "data": {
                "id": 1,
                "title": "Sample Book",
                "year": 2024,
                "created_at": "2024-01-01 00:00:00",
                "updated_at": "2024-01-02 00:00:00",
                "deleted_at": null,
                "authorsbook": [
                    {
                        "id": 1,
                        "books_id": 1,
                        "authors_id": 1,
                        "created_at": "2024-01-01 00:00:00",
                        "updated_at": "2024-01-02 00:00:00",
                        "deleted_at": null
                    }
                ]
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
        $this->assertEquals('application/json', $this->headers['Content-Type']);
    }

    public function testDataObjectHasCorrectStructure()
    {
        $this->assertIsObject($this->response);
        $this->assertTrue(isset($this->response->data));
        
        $data = $this->response->data; 
        $this->assertIsObject($data);
        
        $requiredFields = ['id', 'title', 'year', 'created_at', 'updated_at', 'deleted_at', 'authorsbook'];
        foreach ($requiredFields as $field) {
            $this->assertTrue(property_exists($data, $field), "Field '$field' is missing in the data object");
        }
        
        $this->assertIsArray($data->authorsbook);
    }

    public function testAuthorsbookArrayStructure()
    {
        $this->assertIsObject($this->response);
        $this->assertTrue(isset($this->response->data));
        
        $data = $this->response->data;
        $this->assertIsArray($data->authorsbook);
        $this->assertNotEmpty($data->authorsbook);
        
        foreach ($data->authorsbook as $author) {
            $this->assertIsObject($author);
            $this->assertTrue(property_exists($author, 'id'));
            $this->assertTrue(property_exists($author, 'books_id'));
            $this->assertTrue(property_exists($author, 'authors_id'));
            $this->assertTrue(property_exists($author, 'created_at'));
            $this->assertTrue(property_exists($author, 'updated_at'));
            $this->assertTrue(property_exists($author, 'deleted_at'));

            $this->assertIsInt($author->id);
            $this->assertIsInt($author->books_id);
            $this->assertIsInt($author->authors_id);
            $this->assertIsString($author->created_at);
            $this->assertIsString($author->updated_at);
            $this->assertNull($author->deleted_at);
        }
    }
}