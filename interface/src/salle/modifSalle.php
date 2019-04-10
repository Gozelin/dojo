<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Salle.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = $_POST["id"];
$name = $_POST["name"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];

$descDelta = json_decode($descDelta);

$salle = new cSalle($id);

$salle->setName($name);
$salle->setDesc($desc);
$salle->setDescDelta($descDelta);

$salle->update();
?>