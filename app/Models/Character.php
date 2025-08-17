<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'age',
        'breed',
        'power',
        'character_type',
        'image_url'
    ];

    public function techniques() : BelongsToMany {
        return $this->belongsToMany(Technique::class, 'characters_techniques');   
    }

}
