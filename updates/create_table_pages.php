<?php namespace Rw\PageBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTablePages extends Migration
{
    public function up()
    {
        Schema::create('rw_pagebuilder_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191)->nullable();
            $table->string('title', 191)->nullable();
            $table->string('subtitle', 191)->nullable();
            $table->string('code', 191)->nullable()->unique();
            $table->string('slug', 191)->nullable()->unique();
            $table->boolean('is_active')->nullable()->default(1);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rw_pagebuilder_pages');
    }
}
