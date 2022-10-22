<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->image ? asset('storage/images' . $this->image) : "https://doodleipsum.com/700x394/flat?i=36abfe5a9ef31c336bcf57f0dd0bd052";
    }
}
