<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediaRatioField extends Migration
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
        
        Schema::table('media_translations', function (Blueprint $table) {
            $table->binary('ratios')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if (Schema::hasColumn('media_translations', 'ratios')) {
        Schema::table('media_translations', function (Blueprint $table) {
          $table->dropColumn(['ratios']);
        });
      }
    }
}
