<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyNotification extends Model
{
    use HasFactory;

    protected $table = 'vacancy_notifications';

    // Allow mass assignment for the following fields
    protected $fillable = [
        'user_id',
        'room_location',
        'room_capacity',
        'rent_amount',
        'additional_info',
    ];

    /**
     * Get the user associated with the vacancy notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
