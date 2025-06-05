<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $fillable = ['title','description' , 'user_id'];


    public function users(){
        return $this->belongsToMany(User::class);
    }



}
