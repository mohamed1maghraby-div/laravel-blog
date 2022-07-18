<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use SebastianBergmann\Environment\Runtime;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
