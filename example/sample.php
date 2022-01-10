<?php

include_once __DIR__ . '/../src/mc/database.php';

$db = new \mc\database("sqlite:sample.db");

$db->query_sql("DROP TABLE IF EXISTS variable");
$db->query_sql("CREATE TABLE variable (name TEXT, value TEXT)");

$db->insert("variable", ["name" => "theme", "value" => "default"]);
$db->insert("variable", ["name" => "page_size", "value" => "20"]);

$variables = $db->select("variable");

foreach ($variables as $variable) {
    echo "{$variable["name"]} = {$variable["value"]}" . PHP_EOL;
}
