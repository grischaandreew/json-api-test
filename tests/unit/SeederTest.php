<?php
use App\Article;
use App\ContactPerson;
use App\Copyright;
use App\FileType;
use App\FuelLabel;
use App\Language;
use App\Magazine;
use App\Media;
use App\Section;
use App\Teaser;
use App\SocialPost;

/**
 * test the seeded database
 */
class SeederTest extends Base\Unit
{
    
    public function testEnv()
    {
      # verify('env DB_CONNECTION = sqlite-test', env('DB_CONNECTION') )->equals("sqlite-test");
      verify('env APP_ENV = testing', env('APP_ENV') )->equals("testing");
    }
    public function testSeed()
    {
      $this->describe("validate seeded database", function(){
        $this->it("Article", function(){
          verify('exists', Article::all()->count())->greaterThan(0);
      
          $article = Article::first();
          verify('has an id', $article->id)->notNull();
          verify('has an origin_id', $article->origin_id)->notNull();
          verify('has an url_slug', $article->url_slug)->notNull();
      
          verify('has an title', $article->title)->notNull();
          verify('has an topic', $article->topic)->notNull();
          verify('has an excerpt', $article->excerpt)->notNull();
          verify('has an content', $article->content)->notNull();
          if( !empty($article->translatedAttributes) ) {
            foreach($article->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $article->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.fuelLabels is not null', $article->fuelLabels() )->notNull();
          verify('relationship.contactPersons is not null', $article->contactPersons() )->notNull();
          verify('relationship.documents is not null', $article->documents() )->notNull();
          verify('relationship.images is not null', $article->images() )->notNull();
          verify('relationship.videos is not null', $article->videos() )->notNull();
          
          
          verify('relationship.filterCategories is null', $article->filterCategories )->null();
        });
        
        $this->it("ContactPerson", function(){
          verify('exists',ContactPerson::all()->count())->greaterThan(0);
      
          $contactPerson = ContactPerson::first();
          verify('has an id', $contactPerson->id)->notNull();
          verify('has an publication_date', $contactPerson->publication_date)->notNull();
      
          if( !empty($contactPerson->translatedAttributes) ) {
            foreach($contactPerson->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $contactPerson->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.image is not null', $contactPerson->image() )->notNull();
          verify('relationship.filterCategories is null', $contactPerson->filterCategories )->null();
        });
        
        $this->it("Copyright", function(){
          verify('exists', Copyright::all()->count())->greaterThan(0);
          $copyright = Copyright::first();
          verify('has an id', $copyright->id)->notNull();
          verify('has an publication_date', $copyright->publication_date)->notNull();
      
          if( !empty($copyright->translatedAttributes) ) {
            foreach($copyright->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $copyright->{$translatedAttribute})->notNull();
            }
          }
          verify('relationship.filterCategories is null', $copyright->filterCategories )->null();
        });
        
        $this->it("FileType", function(){
          verify('exists',FileType::all()->count())->greaterThan(0);
      
          $fileType = FileType::first();
          verify('has an id', $fileType->id)->notNull();
          verify('has an publication_date', $fileType->publication_date)->notNull();
      
          if( !empty($fileType->translatedAttributes) ) {
            foreach($fileType->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $fileType->{$translatedAttribute})->notNull();
            }
          }
          verify('relationship.filterCategories is null', $fileType->filterCategories )->null();
        });
        
        $this->it("FuelLabel", function(){
          verify('exists', FuelLabel::all()->count())->greaterThan(0);
      
          $data = FileType::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
        $this->it("Language", function(){
          verify('exists', Language::all()->count())->greaterThan(0);
          $data = Language::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
        $this->it("Magazine", function(){
          verify('exists', Magazine::all()->count())->greaterThan(0);
          $data = Magazine::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.sections is > 0', $data->sections()->count())->greaterThan(0);
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
        $this->it("Media", function(){
          verify('exists', Media::all()->count())->greaterThan(0);
          $data = Media::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.fileType is not null', $data->fileType)->notNull();
          verify('relationship.filterCategories is not null', $data->filterCategories() )->notNull();
          verify('relationship.copyrights is not null', $data->copyrights() )->notNull();
          verify('relationship.fuelLabels is not null', $data->fuelLabels() )->notNull();
        });
        
        $this->it("Section", function(){
          verify('exists', Section::all()->count())->greaterThan(0);
          $data = Section::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.teasers is > 0', $data->teasers()->count())->greaterThan(0);
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
        $this->it("Teaser", function(){
          verify('exists', Teaser::all()->count())->greaterThan(0);
          $data = Teaser::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          if( !empty($data->translatedAttributes) ) {
            foreach($data->translatedAttributes as $translatedAttribute){
              verify('has translation for ' . $translatedAttribute, $data->{$translatedAttribute})->notNull();
            }
          }
      
          verify('relationship.fuelLabels is > 0', $data->fuelLabels()->count())->greaterThan(0);
          verify('relationship.media is > 0', $data->media()->count())->greaterThan(0);
          verify('relationship.article is there', $data->article)->notNull();
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
        $this->it("SocialPost", function(){
          verify('exists', SocialPost::all()->count())->greaterThan(0);
          $data = SocialPost::first();
          verify('has an id', $data->id)->notNull();
          verify('has an publication_date', $data->publication_date)->notNull();
      
          verify('relationship.language is not null', $data->language)->notNull();
          verify('relationship.media is not null', $data->media() )->notNull();
          verify('relationship.filterCategories is null', $data->filterCategories )->null();
        });
        
      });
    }
}