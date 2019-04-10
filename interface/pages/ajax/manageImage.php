<?php

require_once('../../../public/src/defines.php');
require_once(PATH_INTER."src/secure.php");
require_once('../../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Image.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

// echo "POST:\n";
// var_dump($_POST);
// echo "FILES:\n";
// var_dump($_FILES);

$action = NULL;

if (isset($_POST["action"]))
	$action = $_POST["action"];

if (isset($action)) {
	switch ($action) {
		case "getForm":
			if (isset($_POST["id"])) {
				$img = new cImage($_POST["id"]);
				echo $img->getForm();
			}
		break;
	}
}
?>