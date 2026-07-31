<?php

include __DIR__ . '/../src/Mc/Sql/Query.php';

use Mc\Sql\Query;

$query = Query::select()
    ->fields(['name', 'value'])
    ->table('variable')
    ->where(['name' => 'theme'])
    ->order(['name' => 'ASC'])
    ->limit(1)
    ->build();

echo $query . PHP_EOL;

$query = Query::insert()
    ->table('variable')
    ->fields(['name', 'value'])
    ->values(['name' => 'theme', 'value' => 'default'])
    ->build();

echo $query . PHP_EOL;

$query = new Query([
    Query::TYPE => Query::SELECT,
    Query::TABLE => 'variable',
    Query::FIELDS => ['name', 'value'],
    Query::WHERE => ['name' => 'theme'],
    Query::ORDER => ['name' => 'ASC'],
    Query::LIMIT => ['limit' => 1],
]);

echo $query->build() . PHP_EOL;
