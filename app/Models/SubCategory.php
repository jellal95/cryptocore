<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $category
 */

class SubCategory extends Model
{
    protected $fillable = ['name'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
