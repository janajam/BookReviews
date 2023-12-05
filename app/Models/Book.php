<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Models\Review;

class Book extends Model
{
   use HasFactory;

   public function review(){
    return $this->hasMany(Review::class);
   }


   public function scopeTitle(Builder $query,string $title):Builder|QueryBuilder{
      return $query->where('title','LIKE','%'.$title.'%');
   }


   public function scopewithReviewsCount(Builder $query,$from=null,$to=null):Builder|QueryBuilder{
      return $query->withCount(['review'=>fn(Builder $q)=>$this->dateRangeFilter($q,$from,$to)]);
   }


   public function scopePopuler(Builder $query,$from=null,$to=null):Builder|QueryBuilder{
      return $query->withReviewsCount()
      ->orderBy('review_count','desc');
   }

   public function scopedateRangeFilter(Builder $query,$from=null,$to=null){
      if($from&&!$to){
         $query->where('created_at','>=',$from);
      }
      elseif(!$from&&$to){
         $query->where('created_at','<=',$to);
      }
      elseif($from&&$to){
         $query->whereBetween('created_at',[$from,$to]);
      }
   }


   public function scopewithAvgRate(Builder $query,$from=null,$to=null):Builder|QueryBuilder{
      return $query->withAvg(['review'=>fn(Builder $q)=>$this->dateRangeFilter($q,$from,$to)],'rate');
   }

   public function scopeHightRate(Builder $query,$from=null,$to=null):Builder|QueryBuilder{
      return $query->withAvgRate()
      ->orderBy('review_avg_rate','desc');
   }


   
   public function scopeMinReviews(Builder $query,int $minReview):Builder|QueryBuilder{
      return $query->having('review_count','>=',$minReview);
   }

   public function scopePopulerLastMonth(Builder $query): Builder|QueryBuilder
   {
       return $query->populer(now()->subMonth(), now())
           ->hightRate(now()->subMonth(), now())
           ->minReviews(2);
   }

   public function scopePopulerLast6Months(Builder $query): Builder|QueryBuilder
   {
       return $query->populer(now()->subMonths(6), now())
           ->hightRate(now()->subMonths(6), now())
           ->minReviews(5);
   }

   public function scopeHightRateLastMonth(Builder $query): Builder|QueryBuilder
   {
       return $query->hightRate(now()->subMonth(), now())
           ->populer(now()->subMonth(), now())
           ->minReviews(2);
   }

   public function scopeHightRateLast6Months(Builder $query): Builder|QueryBuilder
   {
       return $query->hightRate(now()->subMonths(6), now())
           ->populer(now()->subMonths(6), now())
           ->minReviews(5);
   }

   protected static function booted(){
            
      static::updated(fn(Book $book)=>cache()->forget('book:' . $book->id));
      static::deleted(fn(Book $book)=>cache()->forget('book:' . $book->id));
     }

}
