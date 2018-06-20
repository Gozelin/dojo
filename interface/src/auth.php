<?php
/*
authentifie l'utilisateur
*/
require_once('../../public/src/defines.php');

session_start();

$login = $_POST["login"];
$password = $_POST["password"];

$login = hash("md5", $login);
$password = hash("md5", $password);


if($login === ADMIN_LOG && $password === ADMIN_PASSWORD)
{
	header("location: ../pages/interface.php");
	$token = uniqid(rand(), true);
	$_SESSION['token'] = $token;
	$_SESSION['token_time'] = new DateTime("now");
	$_SESSION['tab-click'] = "undefined";
}
else
{
	header("location: ../pages/login.php");
}

exit();

?>