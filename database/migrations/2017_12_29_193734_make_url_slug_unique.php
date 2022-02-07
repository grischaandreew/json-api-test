<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeUrlSlugUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * creates database schema for #INFORM-1921 described at https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs/edit?ts=59ddf60e#heading=h.n7yh00k5gfvr
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('magazines', function (Blueprint $table) {
          $table->unique('url_slug');
        });
        
        Schema::table('articles', function (Blueprint $table) {
          $table->unique('url_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magazines', function (Blueprint $table) {
          $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table->getTable());
          if( in_array('magazines_url_slug_unique', $indexes) ) {
            $table->dropUnique(['magazines_url_slug_unique']);
          }
        });
        
        Schema::table('articles', function (Blueprint $table) {
          $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table->getTable());
          if( in_array('articles_url_slug_unique', $indexes) ) {
            $table->dropUnique(['articles_url_slug_unique']);
          }
        });
    }
}
