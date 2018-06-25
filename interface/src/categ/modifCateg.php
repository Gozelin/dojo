<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

$id = $_POST["id"];
$title = $_POST["title"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];
$color = $_POST["color"];

$descDelta = json_decode($descDelta);

echo "<pre>";
var_dump($_FILES);
echo "</pre>";

$categ = new cCategorie($id);

if ($_FILES["image"]["name"] != "") {
	$image = send_file($_FILES["image"]["name"], $_FILES["image"]["tmp_name"]);
	$categ->setImage($image);
}

$categ->setName($title);
$categ->setDesc($desc);
$categ->setDescDelta($descDelta);
$categ->setColor($color);


echo "<pre>";
var_dump($categ);
echo "</pre>";

$categ->update();

$_SESSION["tab-click"] = "categ";

exit();