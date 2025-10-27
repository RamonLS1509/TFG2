<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->decimal('price',8,2)->default(0);
            $table->timestamp('purchased_at');
            $table->timestamps();
            $table->unique(['user_id','game_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
