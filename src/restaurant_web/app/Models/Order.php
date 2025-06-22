<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'reservation_id',
        'order_number',
        'type',
        'status',
        'payment_status',
        'subtotal',
        'tax',
        'discount',
        'delivery_fee',
        'total',
        'delivery_address',
        'notes',
        'prepared_at',
        'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'prepared_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the reservation associated with the order.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the order details for this order.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Check if order is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order is preparing
     */
    public function isPreparing()
    {
        return $this->status === 'preparing';
    }

    /**
     * Check if order is ready
     */
    public function isReady()
    {
        return $this->status === 'ready';
    }

    /**
     * Check if order is delivered
     */
    public function isDelivered()
    {
        return $this->status === 'delivered';
    }

    /**
     * Check if order is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if order is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
} 