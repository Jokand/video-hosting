<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Storage;

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

    public function getVideoUrlAttribute()
    {
        return url(Storage::url($this->video_path));
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
