<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'new_item',
    ];
}
