<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    protected $fillable = ['bill_id', 'user_id', 'amount_paid', 'status'];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
