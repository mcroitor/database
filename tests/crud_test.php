<?php

info("<== CRUD tests ==>");

info("=== TEST GROUP 1 ===");
info("pre-requisites: table `variables`, field `name` - primary key, field `value`");

info("prepare environment...");

$db = new \Mc\Sql\Database("sqlite::memory:");

$db->query("CREATE TABLE variables (name TEXT NOT NULL PRIMARY KEY, value TEXT NOT NULL)");
info("done.");

$variables = new \Mc\Sql\Crud($db, "variables", "name");

info("test 1.1: insert variable with name=language, value=en");

$object = ["name" => "language", "value" => "en"];
$variables->insert($object);
$extracted = $variables->select("language");
info("inserted object = ", $extracted);
test($object == $extracted);

info("test 1.2: insert_or_update variable with name=theme, value=default / insert");

$variables->insertOrUpdate(["name" => "theme", "value" => "default"]);

info("test 1.3: insert_or_update variable with name=theme, value=default / update");

$result = $variables->insertOrUpdate(["name" => "theme", "value" => "default"]);

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

info("test 1.7: delete variable language");
$variables->delete("language");
$result = $variables->select("language");
test(empty($result));

info("test 1.8: count variables");
$variables->insert(["name" => "v1", "value" => "1"]);
$variables->insert(["name" => "v2", "value" => "2"]);
test($variables->count() === 2);

info("test 1.9: filter variables");
$variables->insert(["name" => "f1", "value" => "val1"]);
$variables->insert(["name" => "f2", "value" => "val2"]);
$filtered = $variables->filter(["value" => "val1"]);
test(count($filtered) === 1 && $filtered[0]["name"] === "f1");

info("test 1.10: insertOrIgnore");
$variables->insert(["name" => "unique", "value" => "first"]);
$result = $variables->insertOrIgnore(["name" => "unique", "value" => "second"]);
test($result === false);
$result = $variables->select("unique");
test($result["value"] === "first");

$db->close();