swagger: '2.0'
info:
  title: inform-me-editorial-api
  version: "0.0.0-dev"
  contact:
    name: andreew GmbH
    url: http://www.andreew.ag
  description: |
    *Living Document / WORK IN PROGRESS*
    Me-Media Editorial API Documentation
    ### General Notes
    API is following the [JSONAPI specifications](http://jsonapi.org/).
    API is specified at https://docs.google.com/document/d/128bL7055Op8EkCzC_tP5YTrrX3VRs2l-v7m9pMjLYjs.
    
    ### About this Document
    Read this Document using the [Swagger Online Editor](https://editor.swagger.io/).
    Responses, models, attributes and descriptions may not exist, are incomplete or planned features:
    | TAG        | Description |
    |------------|-------------|
    | PLANNED    | planned features, blueprint for upcoming implementations |
    | INCOMPLETE | allready started feature, but incomplete                 |
    | TODO       | Things that must be cleared, questionable things         |
# URLS, Shemes and base URIs
schemes:
  - https
  - http
servers:
  - url: https://editorial-dev0.media.andreew.ag/
    description: (latest/straight edge version of event api)
  - url: http://editorial-qa0.media.andreew.ag/
    description: (latest stable version of event api)
produces:
  - application/vnd.api+json

# re-usable Parameters
parameters:
  AcceptLanguage:
    in: query
    name: lang
    type: string
    required: false
    description: |
      locale id which is a ISO-639-1 2 letter code and optional Region designator in the format: `de-DE`.
  PageLimit:
    in: query
    name: page[size]
    required: false
    type: number
    format: int64
    description: |
      http://jsonapi.org/format/#fetching-pagination
  PageNumber:
    in: query
    name: page[number]
    required: false
    type: number
    format: int64
    description: |
      http://jsonapi.org/format/#fetching-pagination
  PageSize:
    in: query
    name: page[size]
    required: false
    type: number
    format: int64
    description: |
      http://jsonapi.org/format/#fetching-pagination

# Model definitions
definitions:
<?php
foreach ($jsonDocApi->resources as $resource) {
  ?>

  <?php echo str_singular($resource->name); ?>:
    type: object
    description: |
      <?php echo $resource->documentation ?? ''; ?>

    properties:
      id:
        type: string
      type:
        type: string
      attributes:
        type: object
        properties:
<?php
    if(isset($resource->attributes))
    foreach($resource->attributes as $attributeName) {
      $rule = $resource->attributeRules[$attributeName] ?? null;
      $type = "string";
      if ($rule) {
        $rule = explode("|", $rule);
        if( $rule[0] == "nullable" ) {
          if( isset($rule[1]) ) {
            $type = $rule[1];
          }
        } else {
          $type = $rule[0];
        }
      }
      if ($type == "integer") {
        $type = "number";
      }
      if ( !in_array($type, ["string", "number", "integer", "array", "boolean", "object"] ) ) {
        $type = "string";
      }
      ?>
          <?php echo $attributeName; ?>:
            type: <?php echo $type; echo "\n"; ?>
            description: <?php echo $resource->attributeRules[$attributeName] ?? "''"; echo "\n"; ?>
<?php
    }

    if( sizeof($resource->hasOne) || sizeof($resource->hasMany) ) {
?>
      relationships:
        type: object
        properties:
<?php
              foreach($resource->hasOne as $relationName) {
?>
          <?php echo $relationName; ?>:
            type: object
            description: '#/definitions/<?php echo str_singular($relationName); ?>'
            properties:
              id:
                type: string
              type:
                type: string

<?php
              }
?>
<?php
              foreach($resource->hasMany as $relationName) {
?>
          <?php echo $relationName; ?>:
            type: object
            properties:
              data:
                type: array
                items:
                  type: object
                  description: '#/definitions/<?php echo str_singular($relationName); ?>'
                  properties:
                    id:
                      type: string
                    type:
                      type: string
<?php
              }
  }
?>
<?php
}
?>
# paths
paths:
<?php
foreach ($jsonDocApi->resources as $resource) {
  ?>
  /api/v1/<?php echo $resource->name ?>:
      get:
        summary: list of <?php echo $resource->name; ?>
        
        description: lists <?php echo $resource->name; ?>
        
        parameters:
            - $ref: '#/parameters/AcceptLanguage'
            - $ref: '#/parameters/PageLimit'
            - $ref: '#/parameters/PageNumber'
            - $ref: '#/parameters/PageSize'
<?php
            if(isset($resource->allowedFilteringParameters))
            foreach( $resource->allowedFilteringParameters as $filteringParameter) {
?>
            - name: 'filters[<?php echo $filteringParameter?>]'
              required: false
              type: string
              in: query
              description: <?php echo $resource->queryRules["filter." . $filteringParameter] ?? "''" ?>

<?php
            }
          if (!empty($resource->allowedSortParameters)) {
?>
            - name: sort
              required: false
              type: string
              in: query
              description: |
<?php
              foreach($resource->allowedSortParameters as $allowedSortParameter) {
?>
                - <?php echo $allowedSortParameter ?>

<?php
              }
?>
<?php
}
if (!empty($resource->allowedIncludePaths)) {
?>
            - name: include
              required: false
              type: string
              in: query
              description: |
<?php
              foreach($resource->allowedIncludePaths as $allowedIncludePath) {
?>
                - <?php echo $allowedIncludePath ?>

<?php
              }
}
?>
        responses:
          200:
            description: list of <?php echo $resource->name; ?>

            schema:
              type: object
              properties:
                data:
                  type: array
                  items:
                    $ref: '#/definitions/<?php echo str_singular($resource->name); ?>'
          401:
            description: Unauthorized
          default:
            description: Unexpected error
      post:
        summary: create new <?php echo str_singular($resource->name); ?>
      
        description: create <?php echo str_singular($resource->name); ?>
      
        parameters:
          - name: <?php echo $resource->name; ?>
      
            in: body
            required: true
            schema:
              $ref: '#/definitions/<?php echo str_singular($resource->name); ?>'
        responses:
          200:
            description: created
          401:
            description: Unauthorized
          default:
            description: Unexpected Error
  /api/v1/<?php echo $resource->name ?>/{id}:
      get:
        summary: get one <?php echo str_singular($resource->name); ?> object
    
        description: show one <?php echo str_singular($resource->name); ?>
    
        parameters:
            - $ref: '#/parameters/AcceptLanguage'
            - $ref: '#/parameters/PageLimit'
            - $ref: '#/parameters/PageNumber'
            - $ref: '#/parameters/PageSize'
            - name: id
              in: path
              required: true
              type: string
              description: <?php
                  if( isset($resource->attributes) && in_array('url-slug', $resource->attributes) ) {
                    ?>id or url-slug of object<?php
                  } else {
                    ?>id of object <?php               
                  }
?>

<?php
if (!empty($resource->allowedIncludePaths)) {
?>
            - name: include
              required: false
              type: string
              in: query
              description: |
<?php
              foreach($resource->allowedIncludePaths as $allowedIncludePath) {
?>
                - <?php echo $allowedIncludePath ?>

<?php
              }
          }
?>
        responses:
          200:
            description:  <?php echo $resource->name; ?>

            schema:
              type: object
              properties:
                data:
                  $ref: '#/definitions/<?php echo str_singular($resource->name); ?>'
          401:
            description: Unauthorized
          default:
            description: Unexpected error
      patch:
        summary: update <?php echo str_singular($resource->name); ?>
  
        description: update <?php echo str_singular($resource->name); ?>
  
        parameters:
          - name: <?php echo $resource->name; ?>

            in: body
            required: true
            schema:
              $ref: '#/definitions/<?php echo str_singular($resource->name); ?>'
          - name: id
            in: path
            required: true
            type: string
            description: <?php
            if( isset($resource->attributes) && in_array('url-slug', $resource->attributes) ) {
              ?>id or url-slug of object<?php
            } else {
              ?>id of object <?php               
            }
?>

        responses:
          200:
            description: created
          401:
            description: Unauthorized
          default:
            description: Unexpected Error
      delete:
        summary: remove <?php echo str_singular($resource->name); ?>
  
        description: remove <?php echo str_singular($resource->name); ?>
  
        parameters:
          - name: id
            in: path
            required: true
            type: string
            description: <?php
            if( isset($resource->attributes) && in_array('url-slug', $resource->attributes) ) {
              ?>id or url-slug of object<?php
            } else {
              ?>id of object <?php               
            }
?>

        responses:
          200:
            description: deleted
          401:
            description: Unauthorized
          default:
            description: Unexpected Error
<?php
}
?>    
