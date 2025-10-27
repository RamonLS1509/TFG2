<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->tinyInteger('rating'); // 1..5
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['user_id','game_id']); // 1 reseña por usuario por juego
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
