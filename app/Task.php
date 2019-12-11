<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = ['listing_id', 'title', 'content', 'start_line', 'dead_line', 'status'];

  public function listings() {
    return $this->belongsTo('App\Listing');
  }
}
