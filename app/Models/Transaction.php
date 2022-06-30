<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];
    
    protected $keyType = 'string';

    protected $guarded = [];

    // public function table()
    // {
    //     return $this->belongsTo(Table::class);
    // }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
