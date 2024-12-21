<?php
namespace App\Models;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Category;
use App\Models\Commission;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'price',
        'discount_price',
        'purchase_commission',

        'matching_commission',
        'referral_commission',
        'subscription_fee',

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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

}
