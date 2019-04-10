<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = $_POST["id"];
$name = $_POST["name"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];
$color = $_POST["color"];

$descDelta = json_decode($descDelta);

$categ = new cCategorie($id);

$image = "";
if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
	$image = send_file($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], "categ");
	$categ->setImage($image);
}

$categ->setName($name);
$categ->setDesc($desc);
$categ->setDescDelta($descDelta);
$categ->setColor($color);

$categ->update();