<?php namespace Rw\PageBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTableBlockPage extends Migration
{
    public function up()
    {
        Schema::create('rw_pagebuilder_block_page', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('block_id')->nullable()->unsigned();
            $table->integer('page_id')->nullable()->unsigned();
            $table->integer('sort_order')->nullable()->unsigned()->default(1);

            $table->foreign('block_id', 'rw_pagebuilder_blocks_block_id_foreign')
                ->references('id')->on('rw_pagebuilder_blocks')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('page_id', 'rw_pagebuilder_blocks_page_id_foreign')
                ->references('id')->on('rw_pagebuilder_pages')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('rw_pagebuilder_block_page', function ($table) {
            $table->dropForeign('rw_pagebuilder_blocks_block_id_foreign');
            $table->dropForeign('rw_pagebuilder_blocks_page_id_foreign');
        });
        Schema::dropIfExists('rw_pagebuilder_block_page');
    }
}
