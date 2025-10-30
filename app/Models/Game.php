<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title','slug','developer_id','publisher_id','genre_id','platform_id','release_date','price','description'];

    public function developer() { return $this->belongsTo(Developer::class); }
    public function publisher() { return $this->belongsTo(Publisher::class); }
    public function genres() { return $this->belongsToMany(Genre::class,'game_genre'); }
    public function platforms() { return $this->belongsToMany(Platform::class,'game_platform'); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function purchases() { return $this->hasMany(Purchase::class); }
    public function achievements() { return $this->hasMany(Achievement::class); }
}
