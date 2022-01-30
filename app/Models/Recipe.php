<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Recipe extends Model
{
    public $timestamps = false;
    protected $fillable = ['recipe_name','range_from','range_to','category_id'];
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
