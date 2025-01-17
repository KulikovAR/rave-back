<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->has('priority')) {
            $query->orderBy('priority', 'asc');
        }

        $banners = $query->get();

        return response()->json($banners, 200);
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        return response()->json($banner, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image_path' => 'required|string|max:255',
            'priority' => 'required|integer',
        ]);

        $banner = Banner::create($validated);

        return response()->json($banner, 201);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'priority' => 'sometimes|integer',
        ]);

        $banner->update($validated);

        return response()->json($banner, 200);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully'], 200);
    }
}