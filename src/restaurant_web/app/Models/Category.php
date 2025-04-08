<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    
    // Add the fillable property
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'display_order',
        'is_active',
    ];
}
