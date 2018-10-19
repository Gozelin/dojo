<?php
session_start();

include("../src/secure.php");

require_once('../../../public/src/defines.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

header('Location: ../../pages/content.php');

if($_FILES['horaire'] != NULL)
{
	$numberImg = count($_FILES["horaire"]["name"]);

	for($i=0;$i<$numberImg;$i++) 
	{
		if($_FILES["horaire"]["name"][$i] != NULL)
		{
			$name = "horaire".$i.".jpg";
			unlink(PATH_DOJO."pages/images/horaire/$name");

			$dest = "../../../public/pages/images/horaire/".$name;

			$res = move_uploaded_file($_FILES['horaire']['tmp_name'][$i], $dest);
		}
	}
}

$_SESSION["tab-click"] = "horaire";

exit();