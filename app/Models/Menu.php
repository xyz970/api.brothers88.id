<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','description'];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function transaction_details()
    {
        return $this->hasOne(TransactionDetail::class);
    }
}
