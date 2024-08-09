<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Swagger(
 *     schemes={"https"},
 *     host="mywebsite.com",
 *     basePath="api",
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Documentação",
 *         description="Nossa **API** oferece as principais funcionalidades para o fluxo de um cadastro de um livro e seus autores. ",
 *         @OA\Contact(
 *             email="rafael.frotac@gmail.com"
 *         ),
 *     ),
 *     @OA\SecurityScheme(
 *          securityScheme="sanctum",
 *          type="apiKey",
 *          name="Authorization",
 *          in="header"
 *     ),
 *     @OA\Tag(
 *           name="Overview",
 *           description="Overview"
 *     )
 *     @OA\Tag(
 *           name="Usuários",
 *           description="API Endpoints of Users"
 *     )
 *     @OA\Tag(
 *           name="Autores",
 *           description="API Endpoints of Authors"
 *     )
 *     @OA\Tag(
 *           name="Livros",
 *           description="API Endpoints of Books"
 *     )
 *     @OA\Tag(
 *           name="Empréstimos",
 *           description="API Endpoints of Rentals"
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
