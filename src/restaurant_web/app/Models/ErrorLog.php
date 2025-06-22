<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'error_logs';

    // Add the fillable property
    protected $fillable = [
        'method',          // e.g., 'customer', 'admin', 'staff'
        'user_id',
        'error_code',
        'error_message',
        'stack_trace',
        'additional_data', // JSON data
        'ip_address',
        'user_agent',
        'url',
        'request_method',  // GET, POST, etc.
        'is_resolved',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'is_resolved' => 'boolean',
    ];

    /**
     * Get the user that owns the error log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
