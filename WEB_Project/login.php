<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>XML to Emmet and Back</title>
        <link rel="stylesheet" href="style.css"/>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="login_data">
            <form action="./src/login.php" onsubmit = "return validation()" method="POST" name="login">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <label for="text">Username</label>
                <input class="login_data-field" id="username" name="username" type="text"/>
                <label for="text">Password</label>
                <input class="login_data-field" id="password" name="password" type="password"/>
                <input class="sub_button" name="sub" type="submit" value="Log in"/>
            </form>
            <p>If you dont have a profile you can <a href="registration.php">Signup here</a></p>
        </div>
    </body>
    <script>  
        function validation()  
        {  
            var username=document.getElementById('username').value;
            var pass=document.getElementById('password').value;
            
            if(username.length=="") {  
                alert("Username is empty");  
                return false;  
            }   
            if (pass.length=="") {  
            alert("Password field is empty");  
            return false;  
            }                         
        }  
    </script>   
</html>