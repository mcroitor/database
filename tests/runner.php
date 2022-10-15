<?php

include __DIR__ . '/../src/mc/database.php';
include __DIR__ . '/../src/mc/crud.php';
include __DIR__ . '/../src/mc/query.php';

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

include("database_test.php");
include("select_query_test.php");
include("crud_test.php");
