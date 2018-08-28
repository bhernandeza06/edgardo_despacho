<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
  protected $fillable = [
      'instance_id', 'reminder', 'reminder_date',
  ];

  public function instance()
    {
        return $this->belongsTo('App\Instance');
    }
}
