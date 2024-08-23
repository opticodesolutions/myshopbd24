<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('national_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profession')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_picture')->nullable(); // Assuming you want to store the path to the profile picture
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'father_name',
                'mother_name',
                'nominee_name',
                'religion',
                'blood_group',
                'national_id',
                'date_of_birth',
                'profession',
                'address',
                'profile_picture',
            ]);
        });
    }
}
