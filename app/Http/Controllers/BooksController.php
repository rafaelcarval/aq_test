<?php

namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\AuthorsBooks;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * @OA\Post(
     *     path="/api/books/register",
     *     tags={"Livros"},
     *     summary="Criando um livro",
     *     description="Aqui encontramos as instruções necessárias para o correto desenvolvimento de integração para o input de um novo usuário. <br> Utilizamos o método **POST** onde o paylod esta no body. <br> **Requer autenticação! Use o prefixo bearer {token} em Authorization**",
     *     security={{"sanctum":{}}}, 
     *     @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *     ), 
     *     @OA\Property(
     * 		property="status",
     * 		type="string"
     * 	    ),
     * 	    @OA\Property(
     * 		property="error",
     * 		type="string"
     * 	   ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( required={"title" , "year", "authors"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="year",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="authors",
     *                     type="object"
     *                 ),
     *                 example={"id": 52,"title": "Teste Livro", "year": "2020", "authors": {{"authors_id":1},{"authors_id":2}}}
     *             )
     *         )
     *     ),          
     *     @OA\Response(
     *         response="200",
     *         description="User Created Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="token",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "status": "success",
     *                         "message": "Book created successfully",
     *                         "book": {
     *                             "title": "Teste Livro",
     *                             "year": "1977",
     *                             "updated_at": "2024-08-04T13:19:08.000000Z",
     *                             "created_at": "2024-08-04T13:19:08.000000Z",
     *                             "id": 5
     *                         }
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation request",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="validation error"
     *                     ),
     *                     @OA\Property(
     *                         property="errors",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "message": "The title field is required. (and 1 more error)",
     *                         "errors":{"title":{"The title field is required."}}
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="500 Internal Server Error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": true,
     *                         "message": "SQLSTATE[23000]: Integrity ..."
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */    
    public function register(Request $request){

        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4|integer',
            'authors' => "required|array|min:1",
        ]);

        $book = Books::create([
            'title' => $request->title,
            'year' => $request->year
        ]);
        
        $book->authorsbook()->createMany($request->authors);

        return response()->json([
            'status' => 'success',
            'message' => 'Book created successfully',
            'author' => $book
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/books/update",
     *     tags={"Livros"},
     *     summary="Alterando um livro",
     *     description="Aqui encontramos as instruções necessárias para o correto desenvolvimento de integração para alterar um usuário existente. <br> Utilizamos o método **PUT** onde o paylod esta no body. <br> **Requer autenticação! Use o prefixo bearer {token} em Authorization**",
     *     security={{"sanctum":{}}}, 
     *     @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *      description = "Enter the token with the 'Bearer: ' prefix, e.g. 'Bearer abcde12345'"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( required={"id", "title" , "year", "authors"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="year",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="authors",
     *                     type="object"
     *                 ),
     *                 example={"id": 52,"title": "Teste Livro", "year": "2020", "authors": {{"authors_id":1},{"authors_id":2}}}
     *             )
     *         )
     *     ),     
     *     @OA\Response(
     *         response="200",
     *         description="User Updated Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="token",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "status": true,
     *                         "message": "Book updated Successfully",
     *                         "token": "Bearer 8|KpIWQ5NCinZmPXszvViEJONX038iYaEQ4xzVT8hDe1b0d69e"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="401 Unauthorized",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "message": "Unauthenticated",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Book not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": false,
     *                         "message": "User not found"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="500 Internal Server Error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": false,
     *                         "message": "SQLSTATE[23000]: Integrity ..."
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */    
    public function update(Request $request)
    {
        try {
            
            $request->validate([
                'id' => 'required|int',
                'title' => 'required|string|max:255',
                'year' => 'required|digits:4|integer',
                'authors' => "required|array|min:1",
            ]);
            
            $book = Books::find($request->id);
            
            if(is_null($book)){
                return response()->json([
                    'status' => false,
                    'message' => 'Book not found'
                ], 400);
            }
            
            $book = Books::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );
            
            $book->authorsbook()->delete();
            $book->authorsbook()->createMany($request->authors);

            return response()->json([
                'status' => true,
                'message' => 'Book Updated Successfully',
                'book' => $book,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/books/books",
     *     tags={"Livros"},
     *     summary="Pegando todos os livros cadastrados",
     *     security={{"sanctum":{}}}, 
     *     @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *     ),
     *     description="Aqui encontramos as instruções necessárias para o correto desenvolvimento de integração para pegar todos os usuários cadastrados. <br> Utilizamos o método **GET**. <br> **Requer autenticação! Use o prefixo bearer {token} em Authorization**",
     *     @OA\Response(
     *         response="200",
     *         description="Get User Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="token",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "status": true,
     *                         "message": "User Logged In Successfully",
     *                         "data": {{"id":5,"name":"Rafael","email":"rafael.frotac@gmail.com","email_verified_at":null,"created_at":"2024-04-16T23:58:14.000000Z","updated_at":"2024-04-17T01:42:09.000000Z"},{"id":6,"name":"Rafael","email":"rafael.frotac1@gmail.com","email_verified_at":null,"created_at":"2024-04-17T00:50:22.000000Z","updated_at":"2024-04-17T00:50:22.000000Z"},{"id":12,"name":"Rafael","email":"rafael.frotac2@gmail.com","email_verified_at":null,"created_at":"2024-04-17T01:30:38.000000Z","updated_at":"2024-04-17T01:30:38.000000Z"}}
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="401 Unauthorized",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "message": "Unauthenticated",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="500 Internal Server Error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": false,
     *                         "message": "Throwable errors ..."
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */
    public function books()
    {
        
        $books = Books::with('authorsbook')->find(1);
        return response()->json([
            'status' => true,
            'message' => 'Get Books Successfully',
            'data' => $books,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/delete",
     *     tags={"Livros"},
     *     summary="Deletando um livro cadastrados",
     *     security={{"sanctum":{}}}, 
     *     @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *     ),
     *     description="Aqui encontramos as instruções necessárias para o correto desenvolvimento de integração para alterar um usuário existente. <br> Utilizamos o método **PUT** onde o paylod esta no body. <br> **Requer autenticação! Use o prefixo bearer {token} em Authorization**",
     *     security={{"sanctum":{}}}, 
     *     @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="bearerAuth",
     *      type="http",
     *      scheme="bearer",
     *      bearerFormat="JWT",
     *      description = "Enter the token with the 'Bearer: ' prefix, e.g. 'Bearer abcde12345'"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="int"
     *                 ),
     *                 example={"id": 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Book Deleted Successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="token",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "status": true,
     *                         "message": "Book Deleted Successfully"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="401 Unauthorized",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "message": "Unauthenticated",
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": false,
     *                         "message": "User not found"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="500 Internal Server Error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     example={
     *                         "status": false,
     *                         "message": "SQLSTATE[23000]: Integrity ..."
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */  
    public function delete(Request $request)
    {

        $book = Books::find($request->id);

        if(is_null($book)){
            return response()->json([
                'status' => false,
                'message' => 'book not found'
            ], 400);
        }
        // delete related   
        $authorbooks = AuthorsBooks::where('books_id', $book->id)->delete();        

        $book->delete();
        return response()->json([
            'status' => true,
            'message' => 'Book Deleted Successfully'
        ], 200);
    }
}
