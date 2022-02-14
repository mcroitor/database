<?php

include __DIR__ . '/../src/mc/query.php';

use mc\sql\query;

$query = query::select()
    ->fields(['name', 'value'])
    ->table('variable')
    ->where(['name' => 'theme'])
    ->order(['name' => 'ASC'])
    ->limit(1)
    ->build();

echo $query . PHP_EOL;

$query = query::insert()
    ->table('variable')
    ->fields(['name', 'value'])
    ->values(['name' => 'theme', 'value' => 'default'])
    ->build();

echo $query . PHP_EOL;