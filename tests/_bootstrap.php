<?php
# copy migrated and pre seeded database to _data/testing-database.sqlite before testcase
# inspired from discussion: https://laracasts.com/discuss/channels/general-discussion/laravel-sqlite-database-with-codeception-acceptance
file_put_contents(__DIR__ . '/_data/testing-database.sqlite',
  file_get_contents(__DIR__ . '/_data/testbase-database.sqlite')
);
