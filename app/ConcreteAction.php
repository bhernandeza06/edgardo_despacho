<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConcreteAction extends Model
{
  protected $fillable = [
      'instance_id', 'action', 'reminder',
  ];

  public function instance()
    {
        return $this->belongsTo('App\Instance');
    }
}
