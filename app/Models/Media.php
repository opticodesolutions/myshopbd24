<?php
namespace App\Models;

use App\Models\User;
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

    protected $table = 'medias'; // Explicitly define the table name

    public function products()
    {
        return $this->hasMany(Product::class, 'image');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'image');
    }
}
