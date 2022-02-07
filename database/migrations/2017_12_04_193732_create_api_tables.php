<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTables extends Migration
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
        Schema::create('magazines', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('identifier')->unique();
            $table->string('url_slug')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        
        Schema::create('magazine_section', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('magazine_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        
        Schema::create('sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('section_type')->nullable();
            $table->integer('priority')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        
        Schema::create('section_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('title')->nullable();
            $table->binary('section_headlines')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['section_id','locale']);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
        
        
        Schema::create('teasers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin')->nullable();
            $table->integer('priority')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('teaser_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('teaser_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('title')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['teaser_id','locale']);
            $table->foreign('teaser_id')->references('id')->on('teasers')->onDelete('cascade');
        });
        Schema::create('fuel_label_teaser', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('fuel_label_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('teaser_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::create('section_teaser', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('teaser_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        Schema::create('media_teaser', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('teaser_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        
        
        Schema::create('articles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('origin_id')->nullable();
            $table->string('url_slug')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->dateTime('display_date')->nullable();
            $table->timestamps();
        });
        Schema::create('article_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->mediumText('title')->nullable();
            $table->mediumText('seo_title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('topic')->nullable();
            $table->text('content')->nullable();
            $table->text('formatted_content')->nullable();
            $table->string('location')->nullable();
            $table->string('source')->nullable();
            $table->string('filter')->nullable();
            $table->integer('read_count')->nullable();
            $table->integer('download_count')->nullable();
            $table->integer('share_count')->nullable();
          
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['article_id','locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
        
        Schema::create('article_fuel_label', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('fuel_label_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        Schema::create('article_media', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::create('article_contact_person', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('contact_person_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        Schema::create('article_section', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('article_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('section_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::create('languages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('language_name');
            $table->string('country_name');
            $table->string('iso_language');
            $table->string('iso_country');
            $table->boolean('isDefault');
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        
        
        Schema::create('fuel_labels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->integer('priority')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('fuel_label_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('fuel_label_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->text('text')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();
          
            $table->unique(['fuel_label_id','locale']);
            $table->foreign('fuel_label_id')->references('id')->on('fuel_labels')->onDelete('cascade');
        });
        
        
        
        Schema::create('contact_people', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->char('image_id', 36)->charset('ascii')->collation('ascii_bin')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('contact_person_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('contact_person_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['contact_person_id','locale']);
            $table->foreign('contact_person_id')->references('id')->on('contact_people')->onDelete('cascade');
        });
        
        Schema::create('media', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('publishing_id')->nullable();
            $table->string('media_type')->index();
            $table->string('file_type_id')->nullable();
            $table->integer('priority')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('media_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->text('description')->nullable();
            $table->text('transcription')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('filename')->nullable();
            $table->integer('filesize')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('shelf_number')->nullable();
            $table->integer('duration')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['media_id','locale']);
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
        Schema::create('filter_category_media', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('filter_category_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        Schema::create('fuel_label_media', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('fuel_label_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::create('copyright_media', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('copyright_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::create('file_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->binary('mime_types')->nullable();
            $table->binary('file_extensions')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('file_type_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('file_type_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('name')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['file_type_id','locale']);
            $table->foreign('file_type_id')->references('id')->on('file_types')->onDelete('cascade');
        });
        
        
        Schema::create('filter_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('filter_category_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('filter_category_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->string('name')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['filter_category_id','locale']);
            $table->foreign('filter_category_id')->references('id')->on('filter_categories')->onDelete('cascade');
        });
        
        
        Schema::create('copyrights', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->string('owner')->nullable();
            $table->integer('year')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('copyright_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
          
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('copyright_id', 36)->charset('ascii')->collation('ascii_bin');
          
            $table->text('description')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
          
            $table->string('locale')->index();

            $table->unique(['copyright_id','locale']);
            $table->foreign('copyright_id')->references('id')->on('copyrights')->onDelete('cascade');
        });
        
        Schema::create('social_posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 36)->charset('ascii')->collation('ascii_bin')->unique();
            $table->char('language_id', 36)->charset('ascii')->collation('ascii_bin')->nullable();
            $table->string('origin_id')->nullable();
            $table->string('origin_url', 755)->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('source')->nullable();
            $table->integer('year')->nullable();
            $table->dateTime('publication_date')->nullable();
            $table->timestamps();
        });
        Schema::create('media_social_post', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('media_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->char('social_post_id', 36)->charset('ascii')->collation('ascii_bin');
            $table->integer('sort')->nullable();
        });
        
        Schema::table('article_contact_person', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('contact_person_id')->references('id')->on('contact_people')->onDelete('cascade');
        });
        Schema::table('article_fuel_label', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('fuel_label_id')->references('id')->on('fuel_labels')->onDelete('cascade');
        });
        Schema::table('article_media', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
        Schema::table('article_section', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
        
        Schema::table('copyright_media', function (Blueprint $table) {
            $table->foreign('copyright_id')->references('id')->on('copyrights')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
        Schema::table('filter_category_media', function (Blueprint $table) {
            $table->foreign('filter_category_id')->references('id')->on('filter_categories')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
        Schema::table('fuel_label_teaser', function (Blueprint $table) {
            $table->foreign('fuel_label_id')->references('id')->on('fuel_labels')->onDelete('cascade');
            $table->foreign('teaser_id')->references('id')->on('teasers')->onDelete('cascade');
        });
        Schema::table('fuel_label_media', function (Blueprint $table) {
            $table->foreign('fuel_label_id')->references('id')->on('fuel_labels')->onDelete('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
        
        Schema::table('magazine_section', function (Blueprint $table) {
            $table->foreign('magazine_id')->references('id')->on('magazines')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
        Schema::table('media_social_post', function (Blueprint $table) {
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('social_post_id')->references('id')->on('social_posts')->onDelete('cascade');
        });
        Schema::table('media_teaser', function (Blueprint $table) {
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('teaser_id')->references('id')->on('teasers')->onDelete('cascade');
        });
        Schema::table('section_teaser', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('teaser_id')->references('id')->on('teasers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_section');
        
        Schema::dropIfExists('section_translations');
        
        Schema::dropIfExists('teaser_translations');
        Schema::dropIfExists('fuel_label_teaser');
        Schema::dropIfExists('fuel_label_media');
        Schema::dropIfExists('section_teaser');
        Schema::dropIfExists('media_teaser');
        
        Schema::dropIfExists('article_translations');
        Schema::dropIfExists('article_fuel_label');
        Schema::dropIfExists('article_media');
        Schema::dropIfExists('article_contact_person');
        Schema::dropIfExists('article_section');
        
        Schema::dropIfExists('fuel_label_translations');
        
        Schema::dropIfExists('contact_person_translations');
        
        Schema::dropIfExists('media_translations');
        Schema::dropIfExists('filter_category_media');
        Schema::dropIfExists('copyright_media');
        
        Schema::dropIfExists('file_type_translations');
        
        Schema::dropIfExists('filter_category_translations');
        
        Schema::dropIfExists('copyright_translations');
        
        Schema::dropIfExists('media_social_post');
        
        Schema::dropIfExists('copyrights');
        Schema::dropIfExists('social_posts');
        Schema::dropIfExists('filter_categories');
        
        Schema::dropIfExists('file_types');
        Schema::dropIfExists('media');
        
        Schema::dropIfExists('contact_people');
        Schema::dropIfExists('fuel_labels');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('teasers');
        
        Schema::dropIfExists('sections');
        Schema::dropIfExists('magazines');
    }
}
