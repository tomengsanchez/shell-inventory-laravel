<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
    ];

    // Define the inverse relationship
    // public function items()
    // {
    //     return $this->hasMany(Item::class, 'item_type_id');
    // }
}
