<?php
namespace App\Models;

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
}
