<?php
require_once("../../../public/src/defines.php");
require_once(PATH_CLASS."OrderManager.Class.php");

if (isset($_POST["file"]) && isset($_POST["action"])) {
	$file = $_POST["file"];
	$action = $_POST["action"];
	if (isset($_POST["arg"]))
		$arg = $_POST["arg"];
	if (isset($_POST["order"]))
		$order = json_decode($_POST["order"]);

	$om = new cOrderManager([	"action"=> $action,
								"file"=> $file,
								"order"=> $order,
								"arg"=>$arg]);
	$om->execQuery();
}
?>