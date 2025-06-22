<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FaqCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the FAQs for this category.
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

    /**
     * Automatically generate slug from name when creating/updating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faqCategory) {
            $faqCategory->slug = Str::slug($faqCategory->name);
        });

        static::updating(function ($faqCategory) {
            $faqCategory->slug = Str::slug($faqCategory->name);
        });
    }
} 