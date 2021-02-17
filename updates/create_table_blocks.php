<?php namespace Rw\PageBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTableBlocks extends Migration
{
    public function up()
    {
        Schema::create('rw_pagebuilder_blocks', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191)->nullable();
            $table->integer('type_id')->nullable()->unsigned();
            $table->boolean('is_active')->nullable()->default(1);
            $table->text('fields')->nullable();

            $table->foreign('type_id', 'rw_pagebuilder_blocks_type_id_foreign')
                ->references('id')->on('rw_pagebuilder_block_types')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('rw_pagebuilder_blocks', function ($table) {
            $table->dropForeign('rw_pagebuilder_blocks_type_id_foreign');
        });
        Schema::dropIfExists('rw_pagebuilder_blocks');
    }
}
