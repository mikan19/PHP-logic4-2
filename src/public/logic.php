<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\SpendingAnalyzer;

$dbUserName = "root";
$dbPassword = "password";

$analyzer = new SpendingAnalyzer($dbUserName, $dbPassword);
$analyzer->analyze();
?>