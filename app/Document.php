<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  protected $fillable = [
      'instance_id', 'title', 'link',
  ];

  public function instance()
    {
        return $this->belongsTo('App\Instance');
    }
}
