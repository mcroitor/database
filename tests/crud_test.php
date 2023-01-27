<?php

info("<== CRUD tests ==>");

info("=== TEST GROUP 1 ===");
info("pre-requisites: table `variables`, field `name` - primary key, field `value`");

$dbname = "./sample.db";

info("prepare environment...");

if (file_exists($dbname)) {
    unlink($dbname);
}

$db = new \mc\sql\database("sqlite:{$dbname}");

$db->query_sql("CREATE TABLE variables (name TEXT NOT NULL PRIMARY KEY, value TEXT NOT NULL)");
info("done.");

$variables = new \mc\sql\crud($db, "variables", "name");

info("test 1.1: insert variable with name=language, value=en");

$object = ["name" => "language", "value" => "en"];
$variables->insert($object);
$extracted = $variables->select("language");
info("inserted object = ", $extracted);
test($object == $extracted);

info("test 1.2: insert_or_update variable with name=theme, value=default / insert");

$variables->insert_or_update(["name" => "theme", "value" => "default"]);

info("test 1.3: insert_or_update variable with name=theme, value=default / update");

$result = $variables->insert_or_update(["name" => "theme", "value" => "default"]);

info("test 1.4: select variable with name=language");

$variable = $variables->select("language");
info("selected variable", $variable);
test($variable["name"] == "language");

info("test 1.5: select bulk of variables: from 1, 10 total");
$arr = $variables->all(1, 10);
info("selected data", $arr);
test(count($arr) <= 10);

info("test 1.6: update data, set language = ru");
$data = [ "name" => "language", "value" => "ru"];
$result = $variables->update($data);

$result = $variables->select("language");
info("selected data", $result);
test($result["name"] === "language" && $result["value"] === "ru");
