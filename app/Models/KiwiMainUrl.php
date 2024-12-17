<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiwiMainUrl extends Model
{
    use HasFactory;

    // Define table name if it differs from the plural form of the model name
    protected $table = 'kiwi_main_urls';

    // Fillable columns for mass assignment
    protected $fillable = ['url', 'is_sync'];

    // Ensure the 'id' column is auto-incrementing
    public $incrementing = true;

    // Disable timestamps if not using created_at/updated_at
    public $timestamps = false;
}
