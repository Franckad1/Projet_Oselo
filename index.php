<?php



session_name('PROJET');
session_start();

date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/autoload.php';

$app = new Manager\Application;

$app->Launch();
