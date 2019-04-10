<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$title = isset($_POST["title"]) ? $_POST["title"] : "";
$desc = $_POST["home"];
$descDelta = $_POST["homeDelta"];

$descDelta = json_decode($descDelta);

$home = new cHome();

$home->setTitle($title);
$home->setDesc($desc);
$home->setDescDelta($descDelta);

var_dump($home);

$home->update();
?>
