<?php

info("<== database tests ==>");

info("=== TEST GROUP 1 ===");

$table = "variables";

// test 1.1
info("test 1.1: create database in-memory");

$db = new \Mc\Sql\Database("sqlite::memory:");

test(true); // DB is created in memory

// test 1.2
info("test 1.2: create table {$table} - query_sql method");
$query = "CREATE TABLE {$table} (name TEXT PRIMARY KEY, value TEXT)";
info("query = ", $query);

$result = $db->query($query);
$result = $db->select("sqlite_master", ["name"], ["type" => "table"]);
test($result[0]["name"] === $table);

// test 1.3
info("test 1.3: insert data into {$table} - insert method");
$data = [
    ["name" => "theme", "value" => "default"],
    ["name" => "language", "value" => "en"],
    ["name" => "articles_per_page", "value" => "10"],
    ["name" => "timezone", "value" => "Europe/Chisinau"],
    ["name" => "license", "value" => null]
];
$total_data = count($data);

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
info("total {$total_data} lines", $result);
test(count($result) === $total_data);
info("first line is theme => default", $result[0]);
test($result[0]["name"] === "theme" && $result[0]["value"] === "default");

// test 1.5
info("test 1.5: select data from {$table} - where condition");
$result = $db->select($table, ["*"], ["name LIKE 'theme'"]);
info("total 1 lines", $result);
test(count($result) === 1);
info("first line is theme => default", $result[0]);
test($result[0]["name"] === "theme" && $result[0]["value"] === "default");

// test 1.6
info("test 1.6: select data from {$table} - where condition with null");
$result = $db->select($table, ["*"], ["value" => null]);
info("total 1 lines", $result);
test(count($result) === 1);
info("first line is license => null", $result[0]);
test($result[0]["name"] === "license" && $result[0]["value"] === null);

// test 1.7
info("test 1.5: select data from {$table} - where condition");
$result = $db->select($table, ["*"], ["name" =>  "theme"]);
info("total 1 lines", $result);
test(count($result) === 1);
info("first line is theme => default", $result[0]);
test($result[0]["name"] === "theme" && $result[0]["value"] === "default");

info("test 1.8: selectColumn method");
$names = $db->selectColumn($table, "name");
test(count($names) === $total_data);
test($names[0] === "theme");

info("test 1.9: parseSqlDump method");
// create a temp dump file
$dumpFile = __DIR__ . "/temp_dump.sql";
file_put_contents($dumpFile, "CREATE TABLE dump_test (id INTEGER PRIMARY KEY, val TEXT); INSERT INTO dump_test (val) VALUES ('dump_val');");
$db->parseSqlDump($dumpFile);
$res = $db->select("dump_test");
test(count($res) === 1 && $res[0]["val"] === "dump_val");
unlink($dumpFile);

$db->close();
