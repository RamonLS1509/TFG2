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
 *     @OA\Property(property="password", type="string", example="password1234"),
 *     @OA\Property(property="role", type="string", example="admin"),
 *     @OA\Property(property="remember_token", type="string"),
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
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Platform",
 *     title="Platform",
 *     description="Plataforma de videojuego",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="PlayStation 5"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Developer",
 *     title="Developer",
 *     description="Desarrollador de videojuegos",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Naughty Dog"),
 *     @OA\Property(property="bio", type="string", example="Estudio de desarrollo de videojuegos conocido por las sagas Uncharted"),
 *     @OA\Property(property="website", type="string", example="https://www.naughtydog.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Publisher",
 *     title="Publisher",
 *     description="Editor o distribuidor de videojuegos",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Sony Interactive Entertainment"),
 *     @OA\Property(property="info", type="string", example="Empresa desarrolladora de Hollow Knight"),
 *     @OA\Property(property="website", type="string", example="https://teamcherry.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * ),
 *
 * @OA\Schema(
 *     schema="Game",
 *     title="Game",
 *     description="Videojuego",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Kingdom Hearts"),
 *     @OA\Property(property="slug", type="string", example="Kingdom-Hearts"),
 *     @OA\Property(property="developer_id", type="integer", example=3),
 *     @OA\Property(property="publisher_id", type="integer", example=4),
 *     @OA\Property(property="genre_id", type="integer", example=2),
 *     @OA\Property(property="platform_id", type="integer", example=1),
 *     @OA\Property(property="release_date", type="string", format="date", example="2020-06-19"),
 *     @OA\Property(property="price", type="decimal", example="39.99"),
 *     @OA\Property(property="description", type="string", example="Juego de acción y aventura post-apocalíptico."),
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
 *     @OA\Property(property="price", type="double", example=39.99),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class SwaggerController
{

}
