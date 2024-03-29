<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at','description'];
    
    public function menus()
    {
        return $this->hasOne(Menu::class);
    }
}
