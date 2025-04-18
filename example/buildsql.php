<?php

include __DIR__ . '/../src/mc/query.php';

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
    query::TYPE => query::SELECT,
    query::TABLE => 'variable',
    query::FIELDS => ['name', 'value'],
    query::WHERE => ['name' => 'theme'],
    query::ORDER => ['name' => 'ASC'],
    query::LIMIT => ['limit' => 1],
]);

echo $query->build() . PHP_EOL;
