<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Http\Resources\MyVideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VideoManageController extends Controller
{
    public function list()
    {
        return MyVideoResource::collection(Auth::user()->videos);
    }

    public function store(VideoRequest $request): Response
    {
        /** @var Video $video */
        $video = Auth::user()->videos()->create($request->validated());
        $video->uploadVideo($request->file('video_file'));
        $video->uploadCover($request->file('cover_file'));

        return response()->noContent();
    }

    public function update(Video $video, VideoUpdateRequest $request): Response
    {
        if ($video->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }
        $videoData = [
            'status' => 'on-check'
        ];

        $video->uploadVideo($request->file('video_file'));
        $video->uploadCover($request->file('cover_file'));

        $video->update($videoData + $request->validated());
        return response()->noContent();
    }

    public function delete(Video $video)
    {
        if ($video->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }
        $video->delete();
        return response()->noContent();
    }
}
