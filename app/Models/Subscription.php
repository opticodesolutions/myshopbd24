<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'amount',
        'per_person',
        'per_child_amount',
        'lavel',
        'ref_income',
        'insective_income',
        'daily_bonus',
        'admin_profit_salary',
        'admin_profit',
        'image',
    ];

    public function subscriptionRenews()
    {
        return $this->hasMany(SubcriptioRenew::class, 'subscription_id', 'id');
    }
}
