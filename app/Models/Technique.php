<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
    protected $fillable = [
        'technique',
        'power',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function characters(){
        return $this->belongsToMany(Character::class, 'characters_techniques');
    }
}
