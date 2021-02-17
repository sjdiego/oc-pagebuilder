<?php namespace Rw\PageBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTableBlockTypes extends Migration
{
    public function up()
    {
        Schema::create('rw_pagebuilder_block_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191)->nullable();
            $table->string('partial', 191)->nullable();
            $table->text('fields')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rw_pagebuilder_block_types');
    }
}
