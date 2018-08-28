<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{

  protected $fillable = [
      'customer_id', 'subject', 'recommendations', 'fee', 'wildcard', 'state',
  ];

  public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

  public function concreteActions()
    {
        return $this->hasMany('App\ConcreteAction');
    }

  public function costs()
    {
        return $this->hasMany('App\Cost');
    }
}
