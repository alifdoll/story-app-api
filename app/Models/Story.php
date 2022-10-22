<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image'
    ];

    public function getImage()
    {
        return $this->image ? Storage::url($this->image) : "https://doodleipsum.com/700x394/flat?i=36abfe5a9ef31c336bcf57f0dd0bd052";
    }
}
