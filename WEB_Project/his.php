<?php 
    session_start();
    
    include ("./src/config/config.php");
    $conn =  Config::mysql_conection(); 
    $id = $_SESSION['id'];
    $query = "SELECT * FROM users_conversions Join conversions on conversion_id=conversions.id where user_id='$id' ORDER BY users_conversions.converted_at DESC";
    $res = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>XML to Emmet and Back</title>
        <link rel="stylesheet" href="style.css"/>
        <meta charset="UTF-8">
    </head>
    <body>
        </header>
            <nav>
                <button onclick="location.href='./index.php'" type="button" class="nav_button">Main</button>
                <button onclick="location.href='./his.php'" type="button" class="nav_button">History</button>
                <button onclick="location.href='./src/logout.php'" type="button" class="nav_button">Logout</button>
            </nav>
        </header>
        <form action="./src/openHis.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>From_To</th>
                        <th>Input</th>
                        <th>Result</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php while( $row=mysqli_fetch_array($res)){?>
                    <tr>
                        <td><?php echo $row['converted_at']; ?></td>
                        <td><?php echo $row['from_what_to_what']; ?></td>
                        <td><?php echo htmlspecialchars($row['convertion_input']) ;?></td>
                        <td><?php echo htmlspecialchars($row['result_of_conversion'] );?></td>
                        <td class="for_button">
                        <button class="open_button" name="btn_with_id" type="submit" value="<?php echo $row['conversion_id'] ?>">Open</button>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <div>
                <?php if (isset($_SESSION['his_input_box'])) {?>
                    <textarea class="his_input_box" name="his_input_box" id='his_input_box' value=""><?php print_r( $_SESSION['his_input_box']);?></textarea>  
                <?php }else{?>
                    <textarea class="his_input_box" name="his_input_box" id='his_input_box' value=""></textarea>
                <?php } ?>
                <?php if (isset($_SESSION['his_output_box'])) {?>
                    <textarea class="his_output_box" name="his_output_box" id='his_output_box' value=""><?php print_r( $_SESSION['his_output_box']);?></textarea>  
                <?php }else{?>
                    <textarea class="his_output_box" name="his_output_box" id='his_output_box' value=""></textarea>
                <?php } ?>
            </div>
        </form>
    </body>
</html>