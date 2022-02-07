<?php

namespace App\JsonApi;

use CloudCreativity\LaravelJsonApi\Routing\ApiGroup as Api;

class Registration
{
    public static function getJSONApiRegistration()
    {
        return function ($api) {
            
            $api->resource('magazines', [
              'has-many' => [
                'sections'
               ],
               'controller' => 'BaseController'
            ]);
            
            $api->resource('sections', [
              'has-many' => [
                'teasers'
               ],
               'controller' => 'BaseController'
            ]);
              
            $api->resource('teasers', [
              'has-one' => 'article',
              'has-many' => ['images', 'videos', 'fuel-labels'],
              'controller' => 'BaseController'
            ]);
            
            $api->resource('articles', [
              'has-many' => ['contact-persons', 'images', 'documents', 'videos', 'audios', 'fuel-labels', 'sections'],
              'controller' => 'BaseController'
            ]);
              
            $api->resource('languages', [ 'controller' => 'BaseController' ]);
              
            $api->resource('fuel-labels', [ 'controller' => 'BaseController' ]);
              
            $api->resource('contact-people', [
              'has-one' => 'image',
              'controller' => 'BaseController'
            ]);
              
            $api->resource('media', [
              'has-one' => 'file-type',
              'has-many' => ['copyrights', 'filter-categories', 'fuel-labels'],
              'controller' => 'BaseController'
            ]);
              
            $api->resource('file-types', ['controller' => 'BaseController']);
            
            $api->resource('filter-categories', ['controller' => 'BaseController']);
            
            $api->resource('copyrights', ['controller' => 'BaseController']);
            
            $api->resource('social-posts', [
              'has-one' => 'language',
              'has-many' => ['media'],
              'controller' => 'BaseController'
            ]);
        };
    }
}
