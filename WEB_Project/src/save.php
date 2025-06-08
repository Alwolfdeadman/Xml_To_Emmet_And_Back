<?php
function save($fromto,$content_to_convert,$result, $user_id){
    $conn = Config::mysql_conection(); 
    $sql="INSERT INTO conversions(from_what_to_what, convertion_input, result_of_conversion) VALUES(?,?,?)";
    $query=$conn->prepare($sql);
    $query->bind_param('sss',$fromto,$content_to_convert,$result);
    $exec= $query->execute();

    if($exec==false)
        header("location:../index.php?error=Something went wrong.");

    $convert_id = mysqli_insert_id($conn);
    $date = date('Y-m-d H:i:s');
    $sql2="INSERT INTO users_conversions(user_id,conversion_id,converted_at) VALUES(?,?,?)";
    $query2=$conn->prepare($sql2);
    $query2->bind_param('sss',$user_id,$convert_id,$date);
    $exec2= $query2->execute();
    if($exec2==true)
        header("location:../index.php");
    else
        header("location:../index.php?error=Something went wrong.");

    exit;
}

?>