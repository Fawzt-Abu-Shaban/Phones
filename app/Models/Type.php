<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public static $searchable =
    [
        'name_en',
        'name_ar',
    ];

    // protected $appends = ['visibility_status'];

    public function getVisibilityStatusAttribute()
    {
        return $this->is_visible ? 'Visible' : 'Hidden';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'type_id', 'id');
    }
}
