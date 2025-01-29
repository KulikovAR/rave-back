<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request): ApiJsonResponse
    {
        $banners = $this->bannerService->getAllBanners($request->priority);

        return new ApiJsonResponse(data: $banners);
    }

    public function show($id): ApiJsonResponse
    {
        $banner = $this->bannerService->getBannerById($id);

        if (! $banner) {
            return new ApiJsonResponse(404, false, 'Banner not found');
        }

        return new ApiJsonResponse(data: $banner);
    }

    public function store(Request $request): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image_path' => 'required|string|max:255',
            'priority' => 'required|integer',
            'hidden' => 'boolean',
        ]);

        $banner = $this->bannerService->createBanner($validated);

        return new ApiJsonResponse(201, data: $banner);
    }

    public function update(Request $request, $id): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'priority' => 'sometimes|integer',
            'hidden' => 'sometimes|boolean',
        ]);

        $banner = $this->bannerService->updateBanner($id, $validated);

        if (! $banner) {
            return new ApiJsonResponse(404, false, 'Banner not found');
        }

        return new ApiJsonResponse(data: $banner);
    }

    public function destroy($id): ApiJsonResponse
    {
        $banner = $this->bannerService->deleteBanner($id);

        if (! $banner) {
            return new ApiJsonResponse(404, false, 'Banner not found');
        }

        return new ApiJsonResponse(message: 'Banner deleted successfully');
    }
}
