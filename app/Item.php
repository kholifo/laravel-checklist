<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'item_name', 'checklist_id', 'status'
    ];

    protected $hidden = [];

    public function checklist()
    {
        return $this->belongsTo('App\Checklist');
    }
}
