<?php

namespace App\Models;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'video_path',
        'cover_path',
        'status',
    ];

    public function likes()
    {
        return $this->hasMany(VideoLike::class, 'video_id', 'id');
    }

    public function toggleLike()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'video_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getVideoUrlAttribute()
    {
        return url(Storage::url($this->video_path));
    }

    public function getCoverUrlAttribute()
    {
        return url(Storage::url($this->cover_path));
    }

    public function uploadVideo(?UploadedFile $file)
    {
        if ($file) {
            if ($this->video_path) {
                Storage::delete($this->video_path);
            }
            $this->video_path = $file->store('public/videos');
            $this->save();
        }
    }

    public function uploadCover(?UploadedFile $file)
    {
        if ($file) {
            if ($this->cover_path) {
                Storage::delete($this->cover_path);
            }
            $this->cover_path = $file->store('public/covers');
            $this->save();
        }
    }
}
