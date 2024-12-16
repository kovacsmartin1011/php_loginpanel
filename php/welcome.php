<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Web</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <h1>Üdv, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
    <button class="btn block-cube block-cube-hover pirosbtn" type="button" onclick="window.location.href='../JS Jatek/index.html'">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
            <span class="text">Játék</span>
    </button>
    <button class="btn block-cube block-cube-hover pirosbtn" type="button" onclick="window.location.href='reset-password.php'">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
            <span class="text">Jelszó visszaállítás</span>
    </button>
    <button class="btn block-cube block-cube-hover pirosbtn" type="button" onclick="window.location.href='logout.php'">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
            <span class="text">Kijelentkezés</span>
    </button>
</body>
</html>