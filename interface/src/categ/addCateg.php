<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."OrderManager.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$image = NULL;
$name = $_POST["name"];
$desc = $_POST["desc"];
$descDelta = $_POST["descDelta"];
$color = $_POST["color"];

$descDelta = ($descDelta) ? json_decode($descDelta) : [];

$image = "";
if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {
	$image = send_file($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], "categ");
}

$data = array(
	"name"=>$name,
	"desc"=>$desc,
	"descDelta"=>$descDelta,
	"color"=>$color,
	"image"=>$image,
);

$categ = new cCategorie($data);
$id = $categ->insert();

//adding to order.json
$om = new cOrderManager([	"action"=>"addOrder",
							"file"=>"categ",
							"arg"=>["id"=>$id]]);
$om->execQuery();