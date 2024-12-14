<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsPost extends Model
{
    use HasFactory;

    protected $table = 'jobs_post';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'father_name',
        'mother_name',
        'voter_id',
        'mobile_number',
        'district',
        'upazila',
        'union',
        'ward_no',
        'village_name',
        'nationality',
        'religion',
        'passport_image',
    ];

}

?>