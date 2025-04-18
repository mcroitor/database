<?php

include_once __DIR__ . '/../src/mc/database.php';
include_once __DIR__ . '/../src/mc/query.php';

$db = new \Mc\Sql\Database("sqlite:sample.db");

echo "prepare data" . PHP_EOL;
$db->query("DROP TABLE IF EXISTS variable");
$db->query("CREATE TABLE variable (name TEXT, value TEXT)");

$prop1 = ["name" => "theme", "value" => "default"];
$id1 = $db->insert("variable", $prop1);

echo "inserted id: {$id1}" . PHP_EOL;

$prop2 = ["name" => "language", "value" => "en"];
$id2 = $db->insert("variable", $prop2);

echo "inserted id: {$id2}" . PHP_EOL;

$prop3 = ["name" => "page_size", "value" => "20"];
$id3 = $db->insert("variable", $prop3);

echo "inserted id: {$id3}" . PHP_EOL;
echo "done." . PHP_EOL;

echo "test select" . PHP_EOL;
$variables = $db->select("variable");

foreach ($variables as $variable) {
    echo "{$variable["name"]} = {$variable["value"]}" . PHP_EOL;
}
echo "done." . PHP_EOL;

echo "test query builder" . PHP_EOL;
$query = \Mc\Sql\Query::select()->fields(['name', 'value'])->table('variable')->where(['value' => '20']);

$result = $db->exec($query);

foreach ($result as $variable) {
    echo "{$variable["name"]} = {$variable["value"]}" . PHP_EOL;
}
echo "done." . PHP_EOL;
