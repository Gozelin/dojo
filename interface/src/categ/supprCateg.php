<?php
session_start();

require_once("../../../public/src/defines.php");
require_once(PATH_SRC."function.php");
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."Discipline.Class.php");
require_once(PATH_CLASS."Prof.Class.php");

header('Location: ../../pages/content.php');

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$categs = getAllCategs();

$id = $_POST["id"];

$categ = new cCategorie($id);

$categ->delete();

$_SESSION["tab-click"] = "categ";

exit();

?>