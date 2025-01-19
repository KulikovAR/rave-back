<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerService->getAllBanners($request->priority);
        return response()->json($banners, 200);
    }

    public function show($id)
    {
        $banner = $this->bannerService->getBannerById($id);

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

        $banner = $this->bannerService->createBanner($validated);

        return response()->json($banner, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'priority' => 'sometimes|integer',
        ]);

        $banner = $this->bannerService->updateBanner($id, $validated);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        return response()->json($banner, 200);
    }

    public function destroy($id)
    {
        $banner = $this->bannerService->deleteBanner($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        return response()->json(['message' => 'Banner deleted successfully'], 200);
    }
}