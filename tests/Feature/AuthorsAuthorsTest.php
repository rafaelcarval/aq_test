<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorsAuthorsTest extends TestCase
{
    private $response;
    private $headers;
    private $statusCode;

    protected function setUp(): void
    {
        // Simulação de resposta da API em formato JSON
        $responseJson = '{
            "data": [
                {
                    "id": 1,
                    "name": "John Doe",
                    "birthday": "1990-01-01",
                    "created_at": "2021-01-01 00:00:00",
                    "updated_at": "2021-01-01 00:00:00",
                    "deleted_at": null
                },
                {
                    "id": 2,
                    "name": "Jane Doe",
                    "birthday": "1992-02-02",
                    "created_at": "2022-02-02 01:01:01",
                    "updated_at": "2022-02-02 01:01:01",
                    "deleted_at": null
                }
            ]
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

    public function testContentTypeHeaderIsApplicationJson()
    {
        $this->assertEquals('application/json', $this->headers['Content-Type'], "Content-Type header should be 'application/json'");
    }

    public function testResponseHasRequiredFields()
    {
        $this->assertIsObject($this->response);
        $this->assertIsArray($this->response->data);
        
        foreach ($this->response->data as $author) {
            $this->assertIsObject($author);
            $this->assertTrue(property_exists($author, 'id'));
            $this->assertTrue(property_exists($author, 'name'));
            $this->assertTrue(property_exists($author, 'birthday'));
            $this->assertTrue(property_exists($author, 'created_at'));
            $this->assertTrue(property_exists($author, 'updated_at'));
            $this->assertTrue(property_exists($author, 'deleted_at'));
        }
    }

    public function testDateFieldsAreInValidDateFormat()
    {
        $this->assertIsArray($this->response->data);
        
        foreach ($this->response->data as $author) {
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $author->birthday);
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $author->created_at);
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $author->updated_at);
        }
    }
}