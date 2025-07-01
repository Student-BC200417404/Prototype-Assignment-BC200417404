<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'reservation_date',
        'reservation_time',
        'number_of_guests',
        'status',
        'special_requests',
        'table_number',
        'cancellation_reason',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the reservation.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the orders for this reservation.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the table for this reservation.
     */
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_number', 'table_number');
    }

    /**
     * Check if reservation is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if reservation is confirmed
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if reservation is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if reservation is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
} 