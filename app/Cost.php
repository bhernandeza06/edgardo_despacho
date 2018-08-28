<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
  protected $fillable = [
      'instance_id', 'subject', 'amount',
  ];

  public function instance()
    {
        return $this->belongsTo('App\Instance');
    }
}
