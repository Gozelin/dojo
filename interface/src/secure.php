<?php
/*
vérifie si le token de connection est valide et n'a pas expiré
*/
//temps d'expiration en minutes
$time_expire = 30;

if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]))
{
	$timestamp_old = new Datetime("now");

	$dateDiff = $_SESSION['token_time']->diff($timestamp_old);
	$dateDiffM = $dateDiff->format("%i");
	$dateDiffH = $dateDiff->format("%h");

	//si le token a plus de 15mn : retour à la page login sinon on refresh le token
	if(intval($dateDiffM) > $time_expire && intval($dateDiffH) < 1)
	{
		header("Location: ../pages/login.php");
		exit();
	}
	else
	{
		$_SESSION['token_time'] = new DateTime("now");
	}
}
else
{
	header("Location: ../pages/login.php");
	exit();
}

?>