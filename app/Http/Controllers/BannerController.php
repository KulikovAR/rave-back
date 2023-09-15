<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Resources\Banner\BannerResource;
use App\Http\Resources\Banner\BannerCollection;

class BannerController extends Controller
{
    public function index(Request $request) {

        if ($request->has('action_url')) {
            $banner = Banner::where('action_url', $request->action_url)->firstOrFail();
            return new ApiJsonResponse(data: new BannerResource($banner));
        }

        return new BannerCollection(Banner::paginate(config('pagination.per_page')));
    }
}
