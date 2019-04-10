<?php

session_start();

if (isset($_POST["index"]) && isset($_SESSION[$_POST["index"]])) {
    echo $_SESSION[$_POST["index"]];
}

?>