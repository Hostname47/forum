<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class CategoryStatus extends Model
{
    use HasFactory;

    protected $table = 'category_status';
    protected $guarded = [];

    public function categories() {
        return $this->hasMany(Category::class);
    }
}
