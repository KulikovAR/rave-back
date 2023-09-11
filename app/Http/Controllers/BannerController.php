<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Banner\BannerCollection;
use App\Http\Resources\Banner\BannerShowResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request) {

        if ($request->has('action_url')) {
            $banner = Banner::where('action_url', $request->action_url)->firstOrFail();
            return new ApiJsonResponse(data: new BannerShowResource($banner));
        }

        return new BannerCollection(Banner::paginate(config('pagination.per_page')));
    }
}
