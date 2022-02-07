<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inform2072UpdateSchema extends Migration
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
        Schema::table('articles', function (Blueprint $table) {
          $table->integer('read_count')->nullable();
          $table->integer('download_count')->nullable();
          $table->integer('share_count')->nullable();
        });
        
        // slqite hack: https://github.com/laravel/framework/issues/2979
        Schema::table('article_translations', function (Blueprint $table) {
          $table->dropColumn(['filter', 'read_count', 'download_count', 'share_count']);        
        });
        
        Schema::table('article_translations', function (Blueprint $table) {
          $table->integer('localised_read_count')->nullable();
          $table->integer('localised_download_count')->nullable();
          $table->integer('localised_share_count')->nullable();
          
          $table->text('og_title')->nullable();
          $table->text('og_image')->nullable();
          $table->text('og_description')->nullable();
        });
        
        Schema::table('teasers', function (Blueprint $table) {
          $table->dropColumn('priority');
        });
        
        Schema::table('media', function (Blueprint $table) {
          $table->dropColumn('priority');
        });
        Schema::table('media', function (Blueprint $table) {
          $table->char('storage_uuid', 36)->nullable()->charset('ascii')->collation('ascii_bin');
          $table->integer('filesize')->nullable();
          $table->integer('page_count')->nullable();
          $table->integer('width')->nullable();
          $table->integer('height')->nullable();
          $table->integer('duration')->nullable();
          $table->binary('ratios')->nullable();
          $table->string('mars_publish_id')->nullable();
          $table->string('mars_shelf_number')->nullable();
          $table->string('mars_archive_number')->nullable();
          $table->string('content_language')->nullable();
        });
        
        Schema::table('media_translations', function (Blueprint $table) {
          $table->dropColumn([
            'transcription', 'page_count', 'filename', 'filesize', 'width', 'height', 'shelf_number', 'duration', 'publication_date', 'ratios'
          ]);
        });
        Schema::table('media_translations', function (Blueprint $table) {
          $table->text('og_title')->nullable();
          $table->text('og_image')->nullable();
          $table->text('og_description')->nullable();
        });

        Schema::table('fuel_labels', function (Blueprint $table) {
          $table->dropColumn('priority');
        });
        
        Schema::table('sections', function (Blueprint $table) {
          $table->dropColumn('priority');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('articles', function (Blueprint $table) {
        $table->dropColumn([
          'read_count', 'download_count', 'share_count'
        ]);
      });
      
      Schema::table('article_translations', function (Blueprint $table) {
        $table->string('filter')->nullable();
        
        $table->integer('read_count')->nullable();
        $table->integer('download_count')->nullable();
        $table->integer('share_count')->nullable();
      });
      Schema::table('article_translations', function (Blueprint $table) {
        $table->dropColumn([
          'localised_read_count',
          'localised_download_count',
          'localised_share_count',
          'og_title', 'og_image', 'og_description']);
      });
      
      Schema::table('teasers', function (Blueprint $table) {
        $table->integer('priority')->nullable();
      });
      
      Schema::table('sections', function (Blueprint $table) {
        $table->integer('priority')->nullable();
      });
      
      Schema::table('fuel_labels', function (Blueprint $table) {
        $table->integer('priority')->nullable();
      });
      
      
      Schema::table('media', function (Blueprint $table) {
        $table->dropColumn([
          'storage_uuid', 'filesize', 'page_count', 'width', 'height', 'duration', 'ratios', 'mars_publish_id', 'mars_shelf_number', 'mars_archive_number', 'content_language'
        ]);
      });
      Schema::table('media', function (Blueprint $table) {
        $table->integer('priority')->nullable();        
      });
      
      Schema::table('media_translations', function (Blueprint $table) {
        $table->binary('ratios')->nullable();
        $table->text('transcription')->nullable();
        $table->integer('page_count')->nullable();
        $table->string('filename')->nullable();
        $table->integer('filesize')->nullable();
        $table->integer('width')->nullable();
        $table->integer('height')->nullable();
        $table->string('shelf_number')->nullable();
        $table->integer('duration')->nullable();
        $table->dateTime('publication_date')->nullable();
      });
      
      Schema::table('media_translations', function (Blueprint $table) {
        $table->dropColumn([
          'og_title', 'og_image', 'og_description'
        ]);
      });
    }
}
