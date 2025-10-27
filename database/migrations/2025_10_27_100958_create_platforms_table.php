<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformsTable extends Migration
{
    public function up()
    {
        Schema::create('platforms', function(Blueprint $table){
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('game_platform', function(Blueprint $table){
            $table->id();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('platform_id')->constrained('platforms')->cascadeOnDelete();
            $table->unique(['game_id','platform_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_platform');
        Schema::dropIfExists('platforms');
    }
}
