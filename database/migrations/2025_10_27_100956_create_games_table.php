<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('developer_id')->nullable()->constrained('developers')->cascadeOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained('publishers')->cascadeOnDelete();
            $table->foreignId('genre_id')->nullable()->constrained('genres')->cascadeOnDelete();
            $table->foreignId('platform_id')->nullable()->constrained('platforms')->cascadeOnDelete();
            $table->date('release_date')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
