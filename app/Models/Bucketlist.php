<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bucketlist extends Model
{
    protected $fillable = ['id', 'user_id', 'name','created_at', 'updated_at'];
    protected $hidden = [];

    /**
     * Defines Foreign Key Relationship to the user model
     *
     * @return Object
     */
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    /**
     * Define a one-to-many relationship with App\Item
     */
    public function items(){
        return $this->hasMany('App\Models\Item');
    }
}