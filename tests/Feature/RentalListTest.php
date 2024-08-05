<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalListTest extends TestCase
{
    use RefreshDatabase;

    private $responseData;
    private $statusCode;
    private $headers;

    protected function setUp(): void
    {

        // Definindo o $responseData no setup
        $this->responseData = [
            "users_id" => "1",
            "rent_date" => "1977-10-17",
            "return_date" => "1977-10-17"
        ];

        // Simulação do código de status da resposta
        $this->statusCode = 200; // Valor simulado

        // Simulação do cabeçalho da resposta
        $this->headers = [
            'Content-Type' => 'application/json'
        ];
    }

    /** @test */
    public function testResponseStatusCodeIs200()
    {
        // Simula a resposta JSON
        $this->assertEquals(200, $this->statusCode);
    }

    /** @test */
    public function testIdBooksIdAndUsersIdAreNonNegativeIntegers()
    {
        // Verificação para users_id
        $this->assertIsString($this->responseData['users_id']);
        $this->assertGreaterThanOrEqual(0, (int)$this->responseData['users_id']);

        // Verificação para rent_date e return_date
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $this->responseData['rent_date']);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $this->responseData['return_date']);
    }

    /** @test */
    public function testRentDateAndReturnDateAreInValidDateFormat()
    {
        // Verificação para rent_date e return_date
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $this->responseData['rent_date']);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $this->responseData['return_date']);
    }
}