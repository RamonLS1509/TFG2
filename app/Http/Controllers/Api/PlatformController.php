<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;

class PlatformController extends Controller
{
    /**
     * GET /api/platforms
     * RUTA PÚBLICA
     */
    public function index()
    {
        return response()->json(Platform::orderBy('name')->get(), 200);
    }

    /**
     * GET /api/platforms/{platform}
     */
    public function show(Platform $platform)
    {
        return response()->json($platform, 200);
    }

    /**
     * POST /api/platforms
     * SOLO ADMIN
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:platforms,name|max:100'
        ]);

        $platform = Platform::create($request->only('name'));
        return response()->json($platform, 201);
    }

    /**
     * PUT /api/platforms/{platform}
     * SOLO ADMIN
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:platforms,name,' . $platform->id
        ]);

        $platform->update($request->only('name'));
        return response()->json($platform, 200);
    }

    /**
     * DELETE /api/platforms/{platform}
     * SOLO ADMIN
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();
        return response()->json(null, 204);
    }
}
