<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

  protected $fillable = [
      'id_card', 'full_name', 'mobile', 'phone', 'email', 'address',
  ];

  public function instances()
    {
        return $this->hasMany('App\Instances');
    }
}
