<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    if(empty(trim($_POST["username"]))){
        $username_err = "Írd be a felhasználónevet.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Felhasználónév csak betűkből, számokból és '_'-ból állhat!";
    } else{
        
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
                  
            $param_username = trim($_POST["username"]);         
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "A felhasználónév foglalt.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Valami probléma történt, próbáld meg később.";
            }    
            mysqli_stmt_close($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Írd be a jelszót.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A jelszónak minimum 6 karakterből kell állnia.";
    } else{
        $password = trim($_POST["password"]);
    }
       
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Erősítsd meg a jelszót.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Jelszavak nem egyeznek.";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){           
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            
            
            if(mysqli_stmt_execute($stmt)){
                
                header("location: login.php");
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
    <title>Regisztráció</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form">
        <h1>Regisztráció</h1>
        <div class="control block-cube block-input">
            <input name="username" type="text" placeholder="Felhasználónév" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
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
            <input name="password" type="password" placeholder="Jelszó" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
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
            <input name="confirm_password" type="password" placeholder="Jelszó megerősítése" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
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
            <span class="text">Regisztráció</span>
        </button>
        <button class="btn block-cube block-cube-hover pirosbtn" type="button" onclick="window.location.href='welcome.php'">
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
    </form>
</body>
</html>
