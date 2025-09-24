<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSection extends Model
{
    /** @use HasFactory<\Database\Factories\ContentSectionFactory> */
    use HasFactory,HasUuid;

    protected $fillable = [
        'content_id',
        'sub_chap',
        'title',
        'description',
        'image_id',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
