<?php
require 'functions.php';

if(isset($_POST["signup"])){
    $create_account_status = create_account($_POST["username"],$_POST["password"],$_POST["confirm-password"]);
    if($create_account_status>0){
        header("Location: login.php?s=1");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <?= inc("styles"); ?>
</head>
<body>
    <div class="container">
        <?php if(isset($_POST["signup"])): ?>
            <?php if($create_account_status==0): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>Unknown error: failed to create account</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif($create_account_status==-1): ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>Password dan konfirmasi password tidak sama. Silakan coba lagi.</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>Username sudah terdaftar. Silakan pilih username lain.</div>
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
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password">
            </div>
            <button type="submit" class="btn btn-primary" name="signup">Create Account</button>
            <span>
                Already have an account? 
                <a href="login.php" class="btn text-primary"> Login </a>
                Now!
            </span>
        </form>
    </div>

<?= inc("scripts"); ?>
</body>
</html>