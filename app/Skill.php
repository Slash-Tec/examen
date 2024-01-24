<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function professions()
    {
        return $this->belongsToMany(Profession::class);
    }
}
