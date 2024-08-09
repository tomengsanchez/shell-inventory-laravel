<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "item_name",
        "item_type_id",
    ];

    // Define the relationship to ItemType
    // public function itemType() 
    // {
    //     return $this->belongsTo(ItemType::class, 'item_type_id');
    // }
}
