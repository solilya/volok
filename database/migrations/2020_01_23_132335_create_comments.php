<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('mes')->nullable();
            $table->integer('user_id')->index()->nullable(); 
            $table->integer('ticket_id')->index()->nullable();                       
            $table->integer('client_id')->index()->nullable();                
            $table->timestamps();    
            //
        });
        
        DB::statement('CREATE INDEX mes_comment ON comments (mes(10));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
}
