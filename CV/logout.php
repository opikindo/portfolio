<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
} else {
    if(($_SERVER["REQUEST_METHOD"]=="POST"))
        $_SESSION = [];
        session_unset();
        session_destroy();
    }
    header("Location: index.php");
    exit;
?>