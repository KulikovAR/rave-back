<?php

namespace App\Http\Services;

use App\Models\Banner;

class BannerService
{
    public function getAllBanners($priority = null)
    {
        $query = Banner::query();
        if ($priority !== null) {
            $query->orderBy('priority', 'asc');
        }

        $query->where('hidden', 0);

        return $query->get();
    }

    public function getBannerById($id)
    {
        return Banner::find($id);
    }

    public function createBanner(array $data)
    {
        return Banner::create($data);
    }

    public function updateBanner($id, array $data)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->update($data);
        }

        return $banner;
    }

    public function deleteBanner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
        }

        return $banner;
    }
}
