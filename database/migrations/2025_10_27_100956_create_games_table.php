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
            $table->foreignId('developer_id')->nullable()->constrained('developers')->nullOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained('publishers')->nullOnDelete();
            $table->date('release_date')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->float('average_rating')->default(0); // recalculado por lógica de negocio
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
