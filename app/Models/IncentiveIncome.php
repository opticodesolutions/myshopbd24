<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncentiveIncome extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation_name',
        'child_and_children',
        'matching_sale',
        'amount',
        'text',
    ];
}
