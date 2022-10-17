<?php

$db = new \mc\sql\database("sqlite:sample.db");

info("<== CRUD tests ==>");

info("=== TEST GROUP 1 ===");
info("pre-requisites: table `variables`, field `name` - primary key, field `value`");

$variables = new \mc\sql\crud($db, "variables", "name");

info("test 1.1: select variable with name=language");

$variable = $variables->select("language");
info("selected variable", $variable);
test($variable["name"] == "language");

info("test 1.2: select bulk of variables: from 1, 10 total");
$arr = $variables->all(1, 10);
info("selected data", $arr);
test(count($arr) <= 10);

info("test 1.3: update data, set language = ru");
$data = [ "name" => "language", "value" => "ru"];
$result = $variables->update($data);

$result = $variables->select("language");
info("selected data", $result);
test($result["name"] === "language" && $result["value"] === "ru");
