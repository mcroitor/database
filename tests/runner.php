<?php

include_once __DIR__ . '/../src/mc/database.php';
include_once __DIR__ . '/../src/mc/crud.php';
include_once __DIR__ . '/../src/mc/query.php';

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

include_once __DIR__ . "/database_test.php";
include_once __DIR__ . "/select_query_test.php";
include_once __DIR__ . "/crud_test.php";
include_once __DIR__ . "/unique_values_test.php";
