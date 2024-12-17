<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiwiUrl extends Model
{
    use HasFactory;

    protected $table = 'kiwi_urls'; // Table name

    // Define the columns that can be mass-assigned
    protected $fillable = [
        'url',
        'is_sync'
    ];

    // Optionally, set default values for certain columns
    protected $attributes = [
        'is_sync' => false,
    ];
}
