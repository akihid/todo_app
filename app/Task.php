<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = ['listing_id', 'title', 'content', 'start_line', 'dead_line', 'status'];

  const STATUS = [
    1 => [ 'label' => ' 未着手', 'class' => 'badge badge-secondary text-white', 'color' => '#e3342f' ],
    2 => [ 'label' => ' 着手中', 'class' => 'badge badge-info text-white', 'color' => '#6cb2eb' ],
    3 => [ 'label' => ' 完了', 'class' => 'badge badge-success', 'color' => '#38c172' ],
  ];

  public function listing() {
    return $this->belongsTo('App\Listing');
  }

  public function tags()
  {
    return $this->belongsToMany('App\Tag', 'task_tag'); 
  }

  /**
   * 状態のラベルを返す
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
   * 状態の色を返す（カレンダー表示）
   * @return string
   */
  public function getStatusColorattribute()
  {
    $status = $this->attributes['status'];
    return self::STATUS[$status]['color'];
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
   * 期限が本日より過ぎているか
   * @return boolean
   */
  public function getIsDeadlineOverTodayAttribute()
  {
    return (Carbon::today() > $this->attributes['dead_line'] and $this->attributes['status'] != 3)  ? true : false;
  }

  /**
   * タイトルlike検索
   * @return query
   */
  public function scopeSearchTitle($query, $value) {
    if(!empty($value)) {
      $query->where('title', 'like', '%'.$value.'%');
    }
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
   * タグ検索
   * @return query
   */
  public function scopeSearchTag($query, $value) {
    if(!empty($value)) {
      $query->with('tags')
            ->whereHas('tags', function($query) use ($value) {
              $query->where('tags.name', '=', $value);
            });
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

  /**
   * ソート
   * @return query
   */
  public function scopeSort($query, $column) {
    switch ($column) {
      case "status":
        $query->orderBy($column, 'desc');
        break;
      case "dead_line":
        $query->orderBy($column, 'asc');
        break;
      default:
        $query->orderBy('updated_at', 'desc');
        break;
    }
  }

  /**
   * 期限切れのタスク件数取得
   * @return query
   */
  public function scopeExpiredCount($query)
  {
    $query->where('dead_line', '<', Carbon::today())
          ->where('status', '!=', '3');
  }
}