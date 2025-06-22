<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'snonym',
        'slug',
        'description',
        'price',
        'discount_price',
        'image',
        'is_vegetarian',
        'is_spicy',
        'is_available',
        'ingredients',
        'nutritional_info',
        'preparation_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_vegetarian' => 'boolean',
        'is_spicy' => 'boolean',
        'is_available' => 'boolean',
        'ingredients' => 'array',
        'nutritional_info' => 'array',
    ];

    /**
     * Get the category that owns the menu item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order details for this menu item.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Automatically generate slug from name when creating/updating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($menu) {
            $menu->slug = Str::slug($menu->name);
        });

        static::updating(function ($menu) {
            $menu->slug = Str::slug($menu->name);
        });
    }
}
