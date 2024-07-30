<?php
namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'src',
        'path',
        'type',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'image');
    }
}
