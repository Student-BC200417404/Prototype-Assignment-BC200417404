<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'snonym',
        'slug',
        'description',
        'image',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the sub category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Automatically generate slug from name when creating/updating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name);
        });

        static::updating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name);
        });
    }
} 