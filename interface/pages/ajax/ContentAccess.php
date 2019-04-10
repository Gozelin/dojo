<?php

session_start();

require_once('../../../public/src/defines.php');
require_once('../../../public/src/function.php');
require_once(PATH_INTER."src/secure.php");
require_once(PATH_CLASS."DataBase.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

if (isset($_POST["action"])) {
	$action = $_POST["action"];
	
	switch($action) {
		case "updateAssocPrim":
			updateAssocPrim();
		break;
		case "getAssocPrim":
			getAssocPrimDelta();
		break;
	}
}

function updateAssocPrim() {
	global $dataBase;
	if (isset($_POST["text"]) && isset($_POST["textDelta"])) {
		$text = $dataBase->protect($_POST["text"],  _STRING_);
		$textDelta = $dataBase->protect("\"".$_POST["textDelta"]."\"", _ARRAY_);
		$query = "UPDATE site_content SET assoc_prim = $text, assoc_primDelta = $textDelta WHERE id=1";
		echo $query;
		echo $dataBase->query($query);
	}
}

function parseBackQuill($str) {
	$str = substr($str, 1, -1);
	return ($str);
}

function getAssocPrimDelta() {
	global $dataBase;
	$query = "SELECT assoc_prim, assoc_primDelta FROM site_content";
	$ret = $dataBase->query($query, FETCH_ASSOC);
	$ret["assoc_prim"] = $dataBase->unprotect($ret["assoc_prim"], _STRING_);
	$ret["assoc_primDelta"] = $dataBase->unprotect($ret["assoc_primDelta"], _ARRAY_);
	$ret["assoc_primDelta"] = parseBackQuill($ret["assoc_primDelta"]);
	$ret = json_encode($ret, true);
	echo $ret;
}

?>