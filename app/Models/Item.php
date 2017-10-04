<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = ['item_name','bucketlist_id','user_id','done'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Define an inverse one-to-many relationship with App\Bucketlist.
     */
     public function item(){
        return $this->belongsTo('App\Models\Bucketlist');
    }
}