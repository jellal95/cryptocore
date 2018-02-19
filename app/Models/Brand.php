<?php

namespace App\Models;

use App\Admin\Product;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}