<?php

info("<== unique values database tests ==>");

info("=== TEST GROUP 1 ===");

$dbname = __DIR__ . DIRECTORY_SEPARATOR . "sample.db";
$table = "data";
$columnName = "name";

info("prepare: create database {$dbname}");

if (file_exists($dbname)) {
    unlink($dbname);
}

$db = new \mc\sql\database("sqlite:{$dbname}");

$query = "CREATE TABLE {$table}
    (id INTEGER PRIMARY KEY AUTOINCREMENT,
    {$columnName} TEXT, value TEXT)";

$result = $db->query_sql($query);

$data = [
    [$columnName => "color", "value" => "white"],
    [$columnName => "color", "value" => "black"],
    [$columnName => "color", "value" => "red"],
    [$columnName => "color", "value" => "blue"],
    [$columnName => "color", "value" => "green"],
    [$columnName => "size", "value" => "12"],
    [$columnName => "size", "value" => "20"],
    [$columnName => "style", "value" => "normal"],
    [$columnName => "style", "value" => "italic"],
    [$columnName => "style", "value" => "bold"],
];

info("data for inserting", $data);
foreach ($data as $values) {
    $result = $db->insert($table, $values);
    info("last insert id", $result);
}

info("test 1.1: select unique values");
$result = $db->unique_values($table, $columnName);
info("total 3 unique values", $result);
test(count($result) === 3);

info("test 1.1: count unique values");
$result = $db->count_unique_values($table, $columnName);
info("total 3 unique values", $result);
test(count($result) === 3);

$db->close();