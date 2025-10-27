<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * GET /api/genres
     * RUTA PÚBLICA
     */
    public function index()
    {
        return response()->json(Genre::orderBy('name')->get(), 200);
    }

    /**
     * GET /api/genres/{genre}
     */
    public function show(Genre $genre)
    {
        return response()->json($genre, 200);
    }

    /**
     * POST /api/genres
     * SOLO ADMIN (protegido por middleware role:admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name|max:100'
        ]);

        $genre = Genre::create($request->only('name'));
        return response()->json($genre, 201);
    }

    /**
     * PUT /api/genres/{genre}
     * SOLO ADMIN
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,' . $genre->id
        ]);

        $genre->update($request->only('name'));
        return response()->json($genre, 200);
    }

    /**
     * DELETE /api/genres/{genre}
     * SOLO ADMIN
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(null, 204);
    }
}
