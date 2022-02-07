<?php

use Illuminate\Database\Seeder;
use Faker as Faker;

class MagazinesTableSeeder extends Seeder
{
  
    const FAKTOR = 1;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faktor = 1;
      
      $faker = Faker\Factory::create();
      
      
      $filterCategories = factory('App\FilterCategory', 2 * self::FAKTOR)->create()->toArray();
      $copyrights = factory('App\Copyright', 1 * self::FAKTOR)->create()->toArray();
      $languages = factory('App\Language', 1 * self::FAKTOR)->create()->toArray();
      
      $maxFilterCategoriesPerEntitiy = 2;
      $maxCopyrightsPerEntitiy = 1;
      $maxMediaPerEntitiy = 2;
      $maxLabelsPerEntitiy = 1;
      $maxContactPersonsPerEntitiy = 2;
      $maxSectionsPerEntitiy = 3;
      $maxTeasersPerEntitiy = 5;
      
      $labels = factory('App\FuelLabel', 5 * self::FAKTOR)->create()->toArray();
      
      $media = factory('App\Media', 15 * self::FAKTOR)
          ->create()
          ->each(function($i) use ($faker, $labels, $filterCategories, $copyrights, $maxCopyrightsPerEntitiy, $maxFilterCategoriesPerEntitiy, $maxLabelsPerEntitiy) {
            $_filterCategories = $faker->randomElements($filterCategories, $faker->numberBetween(1, $maxFilterCategoriesPerEntitiy) );
            $_copyrights = $faker->randomElements($copyrights, $faker->numberBetween(1, $maxCopyrightsPerEntitiy ) );
            foreach($_filterCategories as $sort => $_filterCategory) {
              $i->filterCategories()->attach( $_filterCategory["id"], [ "sort" => $sort ] );
            }
            foreach($_copyrights as $sort => $_copyright) {
              $i->copyrights()->attach( $_copyright["id"], [ "sort" => $sort ] );
            }
            $_labels = $faker->randomElements($labels, $faker->numberBetween(1, $maxLabelsPerEntitiy ) );
            foreach($_labels as $sort => $_label) {
              $i->fuelLabels()->attach( $_label["id"], [ "sort" => $sort ] );
            }
          })
          ->toArray();

      $contactPersons = factory('App\ContactPerson', 2 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $media) {
          $_media = $faker->randomElement($media);
          $i->image()->associate($_media["id"]);
          $i->save();
        })
        ->toArray();
          
      $socialPosts = factory('App\SocialPost', 10 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $media, $languages, $maxMediaPerEntitiy) {
          $_language = $faker->randomElement($languages);
          $i->language()->associate($_language["id"]);
          $i->save();
        
          $_media = $faker->randomElements($media, $faker->numberBetween(0, $maxMediaPerEntitiy) );
          foreach($_media as $sort => $_mediaItem) {
            $i->media()->attach( $_mediaItem["id"], [ "sort" => $sort ] );
          }
        })
        ->toArray();
    
      $articles = factory('App\Article', 20 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $contactPersons, $labels, $media, $maxMediaPerEntitiy, $maxContactPersonsPerEntitiy, $maxLabelsPerEntitiy) {
          
          $_labels = $faker->randomElements($labels, $faker->numberBetween(1, $maxLabelsPerEntitiy) );
          foreach($_labels as $sort => $_label) {
            $i->fuelLabels()->attach( $_label["id"], [ "sort" => $sort ] );
          }
          
          $_contactPersons = $faker->randomElements($contactPersons, $faker->numberBetween(1, $maxContactPersonsPerEntitiy) );
          foreach($_contactPersons as $sort => $_contactPerson) {
            $i->contactPersons()->attach( $_contactPerson["id"], [ "sort" => $sort ] );
          }
          
          $_media = $faker->randomElements($media, $faker->numberBetween(1, $maxMediaPerEntitiy) );
          foreach($_media as $sort => $_mediaItem) {
            $i->documents()->attach( $_mediaItem["id"], [ "sort" => $sort ] );
          }
        })
        ->toArray();
      
      $teasers = factory('App\Teaser', 20 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $articles, $labels, $media, $maxMediaPerEntitiy, $maxLabelsPerEntitiy ) {
        
          $_labels = $faker->randomElements($labels, $faker->numberBetween(1, $maxLabelsPerEntitiy) );
          foreach($_labels as $sort => $_label) {
            $i->fuelLabels()->attach( $_label["id"], [ "sort" => $sort ] );
          }
        
          $_media = $faker->randomElements($media, $faker->numberBetween(1, $maxMediaPerEntitiy) );
          foreach($_media as $sort => $_mediaItem) {
            $i->images()->attach( $_mediaItem["id"], [ "sort" => $sort ] );
          }
          
          $_media = $faker->randomElements($media, $faker->numberBetween(1, $maxMediaPerEntitiy) );
          foreach($_media as $sort => $_mediaItem) {
            $i->videos()->attach( $_mediaItem["id"], [ "sort" => $sort ] );
          }
          
          $_article = $faker->randomElement($articles);
          $i->article()->associate($_article["id"]);
          $i->save();
        })
        ->toArray();
      
      $sections = factory('App\Section', 4 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $maxTeasersPerEntitiy, $teasers) {
          $_teasers = $faker->randomElements($teasers, $faker->numberBetween(1, $maxTeasersPerEntitiy) );
          foreach($_teasers as $sort => $_teaser) {
            $i->teasers()->attach( $_teaser["id"], [ "sort" => $sort ] );
          }
          $i->save();        
        })
        ->toArray();
      
      $magazines = factory('App\Magazine', 2 * self::FAKTOR)
        ->create()
        ->each(function($i) use ($faker, $sections, $maxSectionsPerEntitiy ) {
      
          $_maxSectionsPerEntitiy = $maxSectionsPerEntitiy*5 > sizeof($sections) ? sizeof($sections) : $maxSectionsPerEntitiy*5;
          $_sections = $faker->randomElements($sections, $faker->numberBetween(1, $_maxSectionsPerEntitiy) );
          foreach($_sections as $sort => $_section) {
            $i->sections()->attach( $_section["id"], [ "sort" => $sort ] );
          }
          $i->save();
        })
        ->toArray();
      
    }
}
