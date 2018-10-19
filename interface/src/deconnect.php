<?php
require_once('../../public/src/defines.php');

session_start();

header("location: ../pages/login.php");

unset($_SESSION["token"]);
unset($_SESSION["message"]);
unset($_SESSION["tab-click"]);

exit();

?>

