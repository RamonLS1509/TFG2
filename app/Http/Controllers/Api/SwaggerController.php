<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="VideoGames API",
 *     description="API REST para la gestión de videojuegos, reseñas, compras y usuarios. Proyecto Laravel 12 con MySQL.",
 *     @OA\Contact(
 *         email="soporte@videogamesapi.local",
 *         name="Equipo VideoGames API"
 *     )
 * ),
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Servidor local de desarrollo"
 * ),
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * ),
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación y registro de usuarios"
 * ),
 *
 * @OA\PathItem(path="/")
 *
 * ------------------------------------------------------------
 * Modelos para documentación de Swagger
 * ------------------------------------------------------------
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Usuario del sistema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="role", type="string", example="admin"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Genre",
 *     title="Genre",
 *     description="Género de videojuego",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Acción"),
 *     @OA\Property(property="description", type="string", example="Juegos con enfoque en el combate.")
 * ),
 *
 * @OA\Schema(
 *     schema="Platform",
 *     title="Platform",
 *     description="Plataforma de videojuego",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="PlayStation 5"),
 *     @OA\Property(property="manufacturer", type="string", example="Sony")
 * ),
 *
 * @OA\Schema(
 *     schema="Developer",
 *     title="Developer",
 *     description="Desarrollador de videojuegos",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Naughty Dog"),
 *     @OA\Property(property="country", type="string", example="USA")
 * ),
 *
 * @OA\Schema(
 *     schema="Publisher",
 *     title="Publisher",
 *     description="Editor o distribuidor de videojuegos",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Sony Interactive Entertainment"),
 *     @OA\Property(property="country", type="string", example="USA")
 * ),
 *
 * @OA\Schema(
 *     schema="Game",
 *     title="Game",
 *     description="Videojuego",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="The Last of Us Part II"),
 *     @OA\Property(property="description", type="string", example="Juego de acción y aventura post-apocalíptico."),
 *     @OA\Property(property="release_date", type="string", format="date", example="2020-06-19"),
 *     @OA\Property(property="genre_id", type="integer", example=2),
 *     @OA\Property(property="platform_id", type="integer", example=1),
 *     @OA\Property(property="developer_id", type="integer", example=3),
 *     @OA\Property(property="publisher_id", type="integer", example=4),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Review",
 *     title="Review",
 *     description="Reseña de un videojuego",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="user_id", type="integer", example=5),
 *     @OA\Property(property="game_id", type="integer", example=2),
 *     @OA\Property(property="rating", type="integer", example=5),
 *     @OA\Property(property="comment", type="string", example="Excelente jugabilidad y narrativa."),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Purchase",
 *     title="Purchase",
 *     description="Compra de un videojuego",
 *     @OA\Property(property="id", type="integer", example=15),
 *     @OA\Property(property="user_id", type="integer", example=3),
 *     @OA\Property(property="game_id", type="integer", example=8),
 *     @OA\Property(property="quantity", type="integer", example=1),
 *     @OA\Property(property="total_price", type="number", format="float", example=59.99),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class SwaggerController
{
    // Este controlador no necesita métodos
}
