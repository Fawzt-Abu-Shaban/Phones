<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    // protected $fillable = ['user_id', 'album'];
    protected $guarded = [];

    public static $searchable =
    [
        'name_en',
        'name_ar',
        'price',
    ];

    public function getVisibilityStatusAttribute()
    {
        return $this->discount ? 'Yes' : 'No';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorit::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'price' => $this->price,
        ];
    }

    // /**
    //  * Get the indexable data array for the model.
    //  *
    //  * @return array
    //  */
    // // #[SearchUsingPrefix(['name_en', 'name_ar', 'price'])]
    // // #[SearchUsingFullText(['price'])]
    // public function toSearchableArray()
    // {
    //     return [
    //         'id' => $this->id,
    //         'name_en' => $this->name_en,
    //         'name_ar' => $this->name_ar,
    //         'price' => $this->price,
    //     ];
    // }
}
