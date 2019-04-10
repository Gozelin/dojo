<?php
require_once('../../../public/src/defines.php');
require_once('../../../public/src/function.php');
require_once(PATH_CLASS."DataBase.Class.php");
require_once(PATH_CLASS."Home.Class.php");

$dataBase = new cDataBase(DATABASE_HOST, DATABASE_ADMIN_LOG, DATABASE_ADMIN_PASSWORD, DATABASE_ADMIN_NAME);

$home = new cHome();
echo $home->getForm();
?>