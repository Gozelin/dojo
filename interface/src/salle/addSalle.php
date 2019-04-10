<?php

session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Salle.Class.php");
require_once(PATH_CLASS."Gallery.Class.php");
require_once(PATH_CLASS."OrderManager.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$arr = [];

if (isset($_POST)) {
	if (isset($_POST["name"]))
		$arr["name"] = $_POST["name"];
	if (isset($_POST["desc"]))
		$arr["desc"] = $_POST["desc"];
	if (isset($_POST["descDelta"]))
		$arr["descDelta"] = json_decode($_POST["descDelta"]);
	else
		$arr["descDelta"] = [];

	$g = new cGallery();
	$arr["gal"] = $g->insert();

	$s = new cSalle($arr);

	var_dump($s);

	$id = $s->insert();

	// adding to order.json
	$om = new cOrderManager([	"action"=>"addOrder",
								"file"=>"salle",
								"arg"=>["id"=>$id]]);
	$om->execQuery();
}

?>