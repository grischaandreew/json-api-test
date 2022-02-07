<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>memedia EditorialApp JSON.org Api</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                font-size: 12px;
            }
            a {
              color: #636b6f;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: left;
                max-width: 1200px;
                margin: auto;
                padding: 20px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            table {
              border-top: 1px solid #f4f4f4;
              border-right: 1px solid #f4f4f4;
            }
            table td,
            table th {
              border-bottom: 1px solid #f4f4f4;
              border-left: 1px solid #f4f4f4;
              vertical-align: top;
              padding: 3px;
            }
        </style>
    </head>
    <body>
      <div class="position-ref full-height">
        <div class="content">  
   
<table class="table table-striped">
    <thead>
      <tt>
        <th>Name</th>
        <th>Attributes</th>
        <th>Has One</th>
        <th>Has Many</th>
        <th>Allowed Filtering Parameters</th>
        <th>Allowed Include Paths</th>
        <th>Allowed Sort Parameters</th>
        <th>Query Rules</th>
        
      </tr>
    </thead>
    <tbody>
    <?php foreach ($jsonDocApi->resources as $resource): ?>
      <tr>
        <th>
          <a href="/api/v1/{{ $resource->name }}" target="_blank">
            {{ $resource->name }}
          </a>
        </th>
        <td>
        <?php if (isset($resource->attributes) && count($resource->attributes)): ?>
          <?php foreach ($resource->attributes as $attributeName): ?>
            {{ $attributeName }}<br/>
          <?php endforeach; ?>
        <?php endif ?>
        </td>
        <td>
        <?php if (isset($resource->hasOne) && count($resource->hasOne)): ?>
            <?php foreach ($resource->hasOne as $hasOne): ?>
              {{ $hasOne }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      <td>
        <?php if (isset($resource->hasMany) && count($resource->hasMany)): ?>
            <?php foreach ($resource->hasMany as $hasMany): ?>
              {{ $hasMany }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      <td>
        <?php if (isset($resource->allowedFilteringParameters) && count($resource->allowedFilteringParameters)): ?>
            <?php foreach ($resource->allowedFilteringParameters as $fieldName): ?>
              {{ $fieldName }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      <td>
        <?php if (isset($resource->allowedIncludePaths) && count($resource->allowedIncludePaths)): ?>
            <?php foreach ($resource->allowedIncludePaths as $fieldName): ?>
              {{ $fieldName }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      <td>
        <?php if (isset($resource->allowedSortParameters) && count($resource->allowedSortParameters)): ?>
            <?php foreach ($resource->allowedSortParameters as $fieldName): ?>
              {{ $fieldName }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      <td>
        <?php if (isset($resource->queryRules) && count($resource->queryRules)): ?>
            <?php foreach ($resource->queryRules as $fieldName => $fieldRule): ?>
              {{ $fieldName }} = {{ $fieldRule }}<br/>
            <?php endforeach; ?>
        <?php endif ?>
      </td>
      
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>

      </div>
    </div>
  </body>
</html>
