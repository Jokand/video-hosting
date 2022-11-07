<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoFullResource;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function search()
    {
        $perPage = \request('per_page', 10);
        $videos = Video::query()
        //->where('status', 'publish')
        ->orderBy('created_at', 'DESC');
        return VideoResource::collection($videos->paginate($perPage));
    }

    public function show(Video $video)
    {
        return VideoFullResource::make($video);
    }

    public function like(Video $video)
    {
        if (!$video->toggleLike()) {
            $video->likes()->create([
                'user_id' => Auth::id(),
            ]);
        } else {
            $video->likes()->where('user_id', Auth::id())->delete();
        }
        return response()->noContent();
    }
}
