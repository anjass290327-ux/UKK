<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'returns';
    
    protected $fillable = [
        'borrowing_id',
        'return_date',
        'quantity_returned',
        'condition',
        'notes',
        'received_by',
    ];

    protected $casts = [
        'return_date' => 'datetime',
    ];

    /**
     * Get the borrowing that owns the return.
     */
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    /**
     * Get the user who received the return.
     */
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
