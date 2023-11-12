<?php

info("<== database tests ==>");

info("=== TEST GROUP 1 ===");

$dbname = "sample.db";
$table = "variables";

// test 1.1
info("test 1.1: create database {$dbname}");

if (file_exists($dbname)) {
    unlink($dbname);
}

$db = new \mc\sql\database("sqlite:{$dbname}");

test(file_exists($dbname));

// test 1.2
info("test 1.2: create table {$table} - query_sql method");
$query = "CREATE TABLE {$table} (name TEXT PRIMARY KEY, value TEXT)";
info("query = ", $query);

$result = $db->query_sql($query);
$result = $db->select("sqlite_master", ["name"], ["type" => "table"]);
test($result[0]["name"] === $table);

// test 1.3
info("test 1.3: insert data into {$table} - insert method");
$data = [
    ["name" => "theme", "value" => "default"],
    ["name" => "language", "value" => "en"],
    ["name" => "articles_per_page", "value" => "10"],
    ["name" => "timezone", "value" => "Europe/Chisinau"]
];

info("data for inserting", $data);
foreach ($data as $values) {
    $result = $db->insert($table, $values);
    info("last insert id", $result);
}
info("must be pass always, otherwise script fails");
test(true);

// test 1.4
info("test 1.4: select data from {$table} - select method");
$result = $db->select($table);
info("total 4 lines", $result);
test(count($result) === 4);
info("first line is theme => default", $result[0]);
test($result[0]["name"] === "theme" && $result[0]["value"] === "default");

// test 1.5
info("test 1.5: select data from {$table} - where condition");
$result = $db->select($table, ["*"], ["name LIKE 'theme'"]);
info("total 1 lines", $result);
test(count($result) === 1);
info("first line is theme => default", $result[0]);
test($result[0]["name"] === "theme" && $result[0]["value"] === "default");

$db->close();