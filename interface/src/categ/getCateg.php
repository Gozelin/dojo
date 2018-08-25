<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = $_POST["id"];

$categ = new cCategorie($id);

$data = array(
	"id"=>$id,
	"name"=>$categ->getName(),
	"desc"=>$categ->getDesc(),
	"descDelta"=>$categ->getDescDelta(),
	"color"=>$categ->getColor(),
	"image"=>$categ->getImage(),
	);

$send = json_encode($data);

echo $send;

?>