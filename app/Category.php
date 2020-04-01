<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class Category extends Model
{
    use softDeletes;

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}