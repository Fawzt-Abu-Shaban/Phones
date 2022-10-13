<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static $searchable =
    [
        'name_en',
        'name_ar',
    ];

    protected $appends = ['visibility_status'];

    public function getVisibilityStatusAttribute()
    {
        return $this->is_visible ? 'Visible' : 'Hidden';
    }

    public function type()
    {
        return $this->hasMany(Type::class, 'category_id', 'id');
    }
}
