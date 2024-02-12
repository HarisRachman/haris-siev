<?php
include "../../koneksi.php";

    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);

    $id = $decode['id'];
    $posisi = $decode["posisi"];
    $start_date = $decode["start_date"];
    $end_date = $decode["end_date"];

    $sql = "UPDATE positions SET posisi = '{$posisi}', start_date = '{$start_date}', end_date = '{$end_date}' WHERE id = '{$id}'";
    $run_sql = mysqli_query($conn, $sql);

    if($run_sql){
        echo json_encode(["success"=>true, "message"=>"Data Posisi Berhasil Diubah"]);
    }else{
        echo json_encode(["success"=>false, "message"=>"Server Problem"]);
    }

?>