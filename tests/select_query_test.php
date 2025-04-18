<?php

use \Mc\Sql\Query;

info("<== query tests ==>");

echo "pre-requisites: table `variables`, field `name`, field `value`" . PHP_EOL;

// test 1.1
echo "test 1.1: select query creation" . PHP_EOL;
echo "\ttable in not set, fields are not set" . PHP_EOL;
$MATCH_SELECT = "SELECT * FROM";

$query = Query::select()->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === "SELECT * FROM");

// test 1.2
echo "test 1.2: select query selection" . PHP_EOL;
echo "\tselect from table `variable` all fields" . PHP_EOL;

$MATCH_SELECT = "SELECT name, value FROM variable";

$query = Query::select()
    ->fields(['name', 'value'])
    ->table('variable')
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);

// test 1.3
echo "test 1.3: select query selection" . PHP_EOL;
echo "\tselect from table `variable` first 5 values of `name` field" . PHP_EOL;

$MATCH_SELECT = "SELECT name FROM variable LIMIT 5 OFFSET 0";

$query = Query::select()
    ->fields(['name'])
    ->table('variable')
    ->limit(5)
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);

// test 1.4
echo "test 1.4: select query selection" . PHP_EOL;
echo "\tselect from table `variable` field `value` where `name` field is equal to `theme`" . PHP_EOL;

$MATCH_SELECT = "SELECT value FROM variable WHERE name='theme'";

$query = Query::select()
    ->fields(['value'])
    ->table('variable')
    ->where(['name' => 'theme'])
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);
