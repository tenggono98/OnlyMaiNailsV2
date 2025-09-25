<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        't_order_id',
        'invoice_number',
        'total',
        'status',
        'created_by',
    ];

    public function order()
    {
        return $this->belongsTo(TOrder::class, 't_order_id');
    }
}


