<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory , Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // تحديد الحقول التي يمكن تعبئتها في النموذج
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'weight',
        'quantity',
        'category_id'
    ];
    // تعريف العلاقة مع الفئات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

