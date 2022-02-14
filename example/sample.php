<?php

include_once __DIR__ . '/../src/mc/database.php';
include_once __DIR__ . '/../src/mc/query.php';

$db = new \mc\sql\database("sqlite:sample.db");

echo "prepare data" . PHP_EOL;
$db->query_sql("DROP TABLE IF EXISTS variable");
$db->query_sql("CREATE TABLE variable (name TEXT, value TEXT)");

$db->insert("variable", ["name" => "theme", "value" => "default"]);
$db->insert("variable", ["name" => "page_size", "value" => "20"]);

echo "done." . PHP_EOL;

echo "test select" . PHP_EOL;
$variables = $db->select("variable");

foreach ($variables as $variable) {
    echo "{$variable["name"]} = {$variable["value"]}" . PHP_EOL;
}
echo "done." . PHP_EOL;

echo "test query builder" . PHP_EOL;
$query = \mc\sql\query::select()->fields(['name', 'value'])->table('variable')->where(['value' => '20']);

$result = $db->exec($query);

foreach ($result as $variable) {
    echo "{$variable["name"]} = {$variable["value"]}" . PHP_EOL;
}
echo "done." . PHP_EOL;