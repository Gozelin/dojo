<?php
session_start();

include("../secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC.'function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Salle.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

if (isset($_POST["id"]))
	$id = $_POST["id"];

$salle = new cSalle($id);

$salle->delete();

$_SESSION["tab-click"] = "salle";

//suppr id fron order.json
$om = new cOrderManager([	"action"=>"supprOrder",
							"file"=>"salle",
							"arg"=>["id"=>$id]]);
$om->execQuery();

exit();

?>