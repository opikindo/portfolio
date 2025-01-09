<?php
session_start();
require 'functions.php';

if(isset($_SESSION["login"])){
    header("Location: index.php?s=1");
    exit;
}


if(isset($_POST["login"])){
    $verify = verify_login($_POST["username"],$_POST["password"]);
    if($verify["s"]){
        $_SESSION["login"]=true;
        $_SESSION["user_id"]=$verify["id"];

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?= inc("styles"); ?>
</head>
<body>
    <div class="container">
        <?php if($_SERVER["REQUEST_METHOD"]=="GET"): ?>
            <?php if(isset($_GET["s"]) && $_GET["s"]=="1"): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>Success Create Account</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
            <span>
                Don't have an account? 
                <a href="signup.php" class="btn text-primary"> Signup </a>
                Now!
            </span>
        </form>
    </div>
<?= inc("scripts"); ?>
</body>
</html>


<!-- 

<div class="alert alert-${type} alert-dismissible" role="alert">
    <div>${message}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
wrapper.innerHTML = [
    ``,
    `   `,
    '   ',
    ''
  ].join('')



-->