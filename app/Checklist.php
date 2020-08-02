<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = [
        'checklist_name'
    ];

    protected $hidden = [];

    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
