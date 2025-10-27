<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * GET /api/publishers
     * RUTA PÚBLICA
     */
    public function index()
    {
        return response()->json(Publisher::orderBy('name')->get(), 200);
    }

    /**
     * GET /api/publishers/{publisher}
     */
    public function show(Publisher $publisher)
    {
        return response()->json($publisher->load('games'), 200);
    }

    /**
     * POST /api/publishers
     * SOLO ADMIN
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:publishers,name|max:255',
            'info' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        $publisher = Publisher::create($request->only(['name','info','website']));
        return response()->json($publisher, 201);
    }

    /**
     * PUT /api/publishers/{publisher}
     * SOLO ADMIN
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name,' . $publisher->id,
            'info' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        $publisher->update($request->only(['name','info','website']));
        return response()->json($publisher, 200);
    }

    /**
     * DELETE /api/publishers/{publisher}
     * SOLO ADMIN
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response()->json(null, 204);
    }
}
