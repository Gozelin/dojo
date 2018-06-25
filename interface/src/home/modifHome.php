<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

$title = $_POST["title"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

var_dump($_POST["descDelta"]);

$descDelta = json_decode($descDelta);

$home = new cHome();

$home->setTitle($title);
$home->setDesc($desc);
$home->setDescDelta($descDelta);

$home->update();


$_SESSION["tab-click"] = "home";

exit();
?>
