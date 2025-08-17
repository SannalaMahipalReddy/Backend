<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'admin_id'];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'name');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function users()
{
    return $this->belongsToMany(User::class)->using(RoomUser::class);
}

}
