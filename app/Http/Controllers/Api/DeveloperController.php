<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Developer;

class DeveloperController extends Controller
{
    /**
     * GET /api/developers
     * RUTA PÚBLICA
     */
    public function index()
    {
        return response()->json(Developer::orderBy('name')->get(), 200);
    }

    /**
     * GET /api/developers/{developer}
     */
    public function show(Developer $developer)
    {
        return response()->json($developer->load('games'), 200);
    }

    /**
     * POST /api/developers
     * SOLO ADMIN
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:developers,name|max:255',
            'bio' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        $developer = Developer::create($request->only(['name','bio','website']));
        return response()->json($developer, 201);
    }

    /**
     * PUT /api/developers/{developer}
     * SOLO ADMIN
     */
    public function update(Request $request, Developer $developer)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:developers,name,' . $developer->id,
            'bio' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        $developer->update($request->only(['name','bio','website']));
        return response()->json($developer, 200);
    }

    /**
     * DELETE /api/developers/{developer}
     * SOLO ADMIN
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();
        return response()->json(null, 204);
    }
}
