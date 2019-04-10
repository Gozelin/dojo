<?php

require_once('../../../public/src/defines.php');
require_once(PATH_P_SRC.'function.php');

$_SESSION['form-id'] = NULL;

if ($_POST["id"])
	$_SESSION['form-id'] = $_POST["id"];

if (isset($_POST["index"])) {
	include(PATH_I_PAGES."form/f_".$_POST["index"].".php");
}

?>