<?php
session_start();

include("../secure.php");

require_once("../../../public/src/defines.php");
require_once(PATH_P_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");

header('Location: ../../pages/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$prof = new cProf($_POST["id"]);

$prof->delete();

$_SESSION["tab-click"] = "prof";

exit();


?>