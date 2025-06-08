<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title>XML to Emmet and Back</title>
        <link rel="stylesheet" href="style.css"/>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="user-data">
            <form action="./src/signup.php" method="POST" name="registration-1form">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <label for="text">Username</label>
                <input class="user-data-field" id="username" name="username" type="text" required minlength="3" maxlength="10"/>
                <label for="text">Email</label>
                <input class="user-data-field" id="email" name="email" type="email" required/>
                <label for="text">Password</label>
                <input class="user-data-field" id="password" name="password" type="password" required/>
                <label for="text">Conforma  tion Password</label>
                <input class="user-data-field" id="conf_password" name="conf_password" type="password" required/>
                <input class="sub_button" name="sub" type="submit" value="Registrate"/>
            </form>
        </div>
        <p>Back to <a href="login.php">login page.</a></p>
    </body>
</html>