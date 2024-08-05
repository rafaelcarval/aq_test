<?php

namespace App\Http\Controllers;
use App\Models\BooksRentals;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BooksRentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function enqueue($mail)
    {
        $details['email'] = $mail;
        dispatch(new SendEmailJob($details));
    }
    /**
     * @OA\Post(
     *     path="/api/rental/register",
     *     tags={"Empréstimos"},
     *     summary="Criando um empréstimo",
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
     *             @OA\Schema( required={"users_id", "books_id", "rent_date", "return_date"},
     *                 @OA\Property(
     *                     property="users_id",
     *                     type="int"
     *                 ),
     *                @OA\Property(
     *                     property="books_id",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="rent_date",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="return_date",
     *                     type="date"
     *                 ),
     *                 example={"users_id": 1, "books_id": 1, "rent_date": "1977-10-17", "return_date": "1977-10-17"}
     *             )
     *         )
     *     ),          
     *     @OA\Response(
     *         response="200",
     *         description="Rental Created Successfully",
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
     *                         "message": "Rental created successfully",
     *                         "rental": {
     *                             "users_id": 1,
     *                             "books_id": 1,
     *                             "rent_date": "1977-10-17",
     *                             "return_date": "1977-10-17",
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
     *                         "message": "The id field is required. (and 1 more error)",
     *                         "errors":{"id":{"The id field is required."}}
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
            'users_id' => 'required|int|max:255',
            'books_id' => 'required|int|max:255',
            'rent_date' => 'required|date',
            'return_date' => 'required|date'
        ]);

        $rental = BooksRentals::create([
            'users_id'      => $request->users_id,
            'books_id'      => $request->books_id,
            'rent_date'     => $request->rent_date,
            'return_date'   => $request->return_date,
        ]);
        
        $user = User::find($request->users_id);

        $this->enqueue($user->email);

        return response()->json([
            'status' => 'success',
            'message' => 'Rental created successfully',
            'rental' => $rental
        ]);
    }

    /**
     * @OA\Get(
     *    path="/api/rental/list",
     *     tags={"Empréstimos"},
     *     summary="Pegando todos os Empréstimos cadastrados",
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
    public function list()
    {
        
        $books = BooksRentals::all();
        return response()->json([
            'status' => true,
            'message' => 'Get all Successfully',
            'data' => $books,
        ], 200);
    }
}
