<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['game_id','name','description','points'];

    public function game() { return $this->belongsTo(Game::class); }
}
