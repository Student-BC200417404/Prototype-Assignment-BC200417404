<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'table_number',
        'capacity',
        'status',
        'location',
    ];

    /**
     * Get the reservations for this table.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_number', 'table_number');
    }

    /**
     * Check if table is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if table is occupied
     */
    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    /**
     * Check if table is reserved
     */
    public function isReserved()
    {
        return $this->status === 'reserved';
    }

    /**
     * Check if table is under maintenance
     */
    public function isUnderMaintenance()
    {
        return $this->status === 'maintenance';
    }
} 