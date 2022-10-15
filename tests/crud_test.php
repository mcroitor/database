<?php

include __DIR__ . '/../src/mc/database.php';
include __DIR__ . '/../src/mc/crud.php';

function test(bool $expression, string $passed = "PASS", string $failed = "FAIL"): void {
    echo $expression ? $passed : $failed;
    echo PHP_EOL;
}

function info(string $message, $object = null): void {
    echo "[info] $message";
    if($object != null){
        echo " - " . json_encode($object);
    }
    echo PHP_EOL;
}

$db = new \mc\sql\database("sqlite:". __DIR__ . "/../sample.db");

info("<== CRUD tests ==>");

info("=== TEST GROUP 1 ===");
info("pre-requisites: table `variables`, field`id` - primary key, field `name`, field `value`");

$variables = new \mc\sql\crud($db, "variables");

info("test 1.1: select variable with id=2");

$variable = $variables->select(2);
info("selected variable", $variable);
test($variable["id"] == 2);

info("test 1.2: select bulk of variables: from 1, 10 total");
$arr = $variables->all(1, 10);
test(count($arr) <= 10);

info("=== TEST GROUP 2 ===");
info("pre-requisites: table `variable`, field `name` - primary key, field `value`");

$variables = new \mc\sql\crud($db, "variable", "name");

info("test 2.1: select variable with name=language");

$variable = $variables->select("language");
info("selected variable", $variable);
test($variable["name"] == "language");

info("test 2.2: select bulk of variables: from 1, 10 total");
$arr = $variables->all(1, 10);
test(count($arr) <= 10);