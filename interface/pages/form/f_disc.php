<?php
require_once('../../../public/src/defines.php');
require_once('../../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Categorie.Class.php");
require_once(PATH_CLASS."Prof.Class.php");
require_once(PATH_CLASS."Video.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$id = NULL;
if (isset($_SESSION["form-id"]))
    $id = $_SESSION["form-id"];

$_SESSION["form-id"] = NULL;

$disc = new cDiscipline($id);

if ($id != NULL)
    echo $disc->getForm(1);
else
    echo $disc->getForm(0);
?>