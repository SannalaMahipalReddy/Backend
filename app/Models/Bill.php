<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the pluralized version of the model (optional)
    protected $table = 'bills';

    // Mass assignable attributes
    protected $fillable = [
        'room_id',
        'created_by',
        'title',
        'category',
        'total_amount',
        'split_method',
        'is_recurring',
        'due_date',
    ];

    // Define relationships

    // Bill belongs to a room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Bill created by a user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
