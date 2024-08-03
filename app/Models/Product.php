<?php
namespace App\Models;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'price',
        'discount_price',
        'description',
        'category_id',
        'brand_id',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'image');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
