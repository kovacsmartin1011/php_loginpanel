<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Írd be a felhasználónevet.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Írd be a jelszót.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
        
            mysqli_stmt_bind_param($stmt, "s", $param_username);  
            
            $param_username = $username;  
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);      
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){                        
                            session_start();                   
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                                    
                            header("location: welcome.php");
                        } else{
                            
                            $login_err = "Hibás felhasználónév vagy jelszó.";
                        }
                    }
                } else{
                    
                    $login_err = "Hibás felhasználónév vagy jelszó.";
                }
            } else{
                echo "Valami probléma történt, próbáld meg később.";
            }
            mysqli_stmt_close($stmt);
        }
    }      
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form">
        <h1>Bejelentkezés</h1>
        <div class="control block-cube block-input">
            <input name="username" type="text" placeholder="Felhasználónév">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
        </div>
        <div class="control block-cube block-input">
            <input name="password" type="password" placeholder="Jelszó">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
        </div>
        <button class="btn block-cube block-cube-hover" type="submit">
            <div class="bg-top">
                <div class="bg-inner"></div>
            </div>
            <div class="bg">
                <div class="bg-inner"></div>
            </div>
            <div class="bg-right">
                <div class="bg-inner"></div>
            </div>
            <span class="text">Bejelentkezés</span>
        </button>
    </div>
    <button class="btn block-cube block-cube-hover pirosbtn" type="button" onclick="window.location.href='register.php'">
        <div class="bg-top">
            <div class="bg-inner"></div>
        </div>
        <div class="bg">
            <div class="bg-inner"></div>
        </div>
        <div class="bg-right">
            <div class="bg-inner"></div>
        </div>
        <span class="text">Regisztráció</span>
    </button>
    </form>
</body>
</html>
