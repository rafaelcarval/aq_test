<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\AuthorsBooks;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * @OA\Post(
     *     path="/api/author/register",
     *     tags={"Autores"},
     *     summary="Criando um autor",
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
     * 	),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( required={"name" , "birthday"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="birthday",
     *                     type="date"
     *                 ),
     *                 example={"name": "Rafael", "birthday": "1977-10-17"}
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
     *                         "message": "Author created successfully",
     *                         "user": {
     *                             "name": "Rafael",
     *                             "birthday": "1977-10-17",
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
     *                         "message": "The name field is required. (and 1 more error)",
     *                         "errors":{"name":{"The name field is required."}}
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
            'name' => 'required|string|max:255',
            'birthday' => 'required|date'
        ]);

        $author = Authors::create([
            'name' => $request->name,
            'birthday' => $request->birthday
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Author created successfully',
            'author' => $author
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/author/update",
     *     tags={"Autores"},
     *     summary="Alterando um autor",
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
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="birthday",
     *                     type="string"
     *                 ),
     *                 example={"id": 1, "name": "Rafael", "birthday": "1977-10-17"}
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
     *                         "message": "User Created Successfully",
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
    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|int',
                'name' => 'required|string|max:255',
                'birthday' => 'required|date'
            ]);
            
            
            $author = Authors::find($request->id);

            if(is_null($author)){
                return response()->json([
                    'status' => false,
                    'message' => 'author not found'
                ], 400);
            }

            $author = Authors::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );

            return response()->json([
                'status' => true,
                'message' => 'Author Updated Successfully',
                'author' => $author
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
     *     path="/api/author/authors",
     *     tags={"Autores"},
     *     summary="Pegando todos os autores cadastrados",
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
    public function authors()
    {
        
        $authors = Authors::all();
        return response()->json([
            'status' => true,
            'message' => 'Get Authors Successfully',
            'data' => $authors,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/author/delete",
     *     tags={"Autores"},
     *     summary="Deletando um autor cadastrados",
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
     *         description="Author Deleted Successfully",
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
     *                         "message": "Author Deleted Successfully"
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

        $author = Authors::find($request->id);

        if(is_null($author)){
            return response()->json([
                'status' => false,
                'message' => 'author not found'
            ], 400);
        }
        // delete related   
        $authorbooks = AuthorsBooks::where('authors_id', $author->id)->delete();        

        $author->delete();
        return response()->json([
            'status' => true,
            'message' => 'Author Deleted Successfully'
        ], 200);
    }
}
