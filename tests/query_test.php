<?php

include __DIR__ . '/../src/mc/query.php';

use mc\sql\query;

function test(bool $expression, string $passed = "PASS", string $failed = "FAIL"): void {
    echo $expression ? $passed : $failed;
    echo PHP_EOL;
}

echo "pre-requisites: table `variable`, field `name`, field `value`" . PHP_EOL;

echo "test 1.1: select query creation" . PHP_EOL;
echo "\ttable in not set, fields are not set" . PHP_EOL;
$MATCH_SELECT = "SELECT * FROM";

$query = query::select()->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === "SELECT * FROM");

echo "test 1.2: select query selection" . PHP_EOL;
echo "\tselect from table `variable` all fields" . PHP_EOL;

$MATCH_SELECT = "SELECT name, value FROM variable";

$query = query::select()
    ->fields(['name', 'value'])
    ->table('variable')
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);

echo "test 1.3: select query selection" . PHP_EOL;
echo "\tselect from table `variable` first 5 values of `name` field" . PHP_EOL;

$MATCH_SELECT = "SELECT name FROM variable LIMIT 5 OFFSET 0";

$query = query::select()
    ->fields(['name'])
    ->table('variable')
    ->limit(5)
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);

echo "test 1.4: select query selection" . PHP_EOL;
echo "\tselect from table `variable` field `value` where `name` field is equal to `theme`" . PHP_EOL;

$MATCH_SELECT = "SELECT value FROM variable WHERE name='theme'";

$query = query::select()
    ->fields(['value'])
    ->table('variable')
    ->where(['name' => 'theme'])
    ->build();

echo "\tmatch: {$MATCH_SELECT}, builded query: {$query}" . PHP_EOL;
echo "\t";
test($query === $MATCH_SELECT);