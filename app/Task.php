<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = ['listing_id', 'title', 'content', 'start_line', 'dead_line', 'status'];

  const STATUS = [
    1 => [ 'label' => ' 未着手', 'class' => 'badge badge-danger' ],
    2 => [ 'label' => ' 着手中', 'class' => 'badge badge-info' ],
    3 => [ 'label' => ' 完了', 'class' => 'badge badge-success' ],
  ];

  /**
   * 状態のラベル
   * @return string
   */
  public function getStatusLabelAttribute()
  {
    $status = $this->attributes['status'];
    return self::STATUS[$status]['label'];
  }
  /**
   * 状態を表すHTMLクラス
   * @return string
   */
  public function getStatusClassAttribute()
  {
    $status = $this->attributes['status'];
    return self::STATUS[$status]['class'];
  }

/**
 * 整形した開始日
 * @return string
 */
  public function getFormattedStartLineAttribute()
  {
    return Carbon::createFromFormat('Y-m-d', $this->attributes['start_line'])
      ->format('Y年m月d日');
  }

  /**
   * 整形した期限日
   * @return string
   */
  public function getFormattedDeadLineAttribute()
  {
    return Carbon::createFromFormat('Y-m-d', $this->attributes['dead_line'])
      ->format('Y年m月d日');
  }

  /**
   * タイトルlike検索
   * @return query
   */
  public function scopeSearchTitle($query, $value) {
    if(!empty($value)) {
      $query->where('title', 'like', '%'.$value.'%');
    }
    // dd($query);
  }

  /**
   * 状態検索
   * @return query
   */
  public function scopeSearchStatus($query, $value) {
    if(!empty($value)) {
      $query->where('status', '=', $value);
    }
  }

  /**
   * 期限検索
   * @return query
   */
  public function scopeSearchDeadline($query, $start, $end) {
    if(!empty($start)) {
      $query->where('dead_line', '>=', $start);
    }

    if(!empty($end)) {
      $query->where('dead_line', '<=', $end);
    }
  }

  public function listing() {
    return $this->belongsTo('App\Listing');
  }
}
