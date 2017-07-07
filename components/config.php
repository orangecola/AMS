<?php

session_start();

$DB_HOST = '127.0.0.1';
$DB_USER = 'ams';
$DB_PASS = 'somethinglikethat';
$DB_NAME = 'ams';

try
{
     $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}


include_once 'components/user.php';
$user = new USER($DB_con);
?>