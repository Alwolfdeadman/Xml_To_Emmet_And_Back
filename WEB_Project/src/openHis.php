<?php
    session_start();

    include ("./config/config.php");
    $conn =  Config::mysql_conection(); 
    $id = $_POST['btn_with_id'];
    $query = "SELECT * FROM conversions WHERE id='$id'";
    $res = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($res);

    $_SESSION['his_input_box'] = htmlspecialchars($row['convertion_input']);
    $_SESSION['his_output_box'] = htmlspecialchars($row['result_of_conversion']);
    header("location:../his.php");

?>