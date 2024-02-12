<?php
include '../../koneksi.php';

    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);

    $posisi = $decode["posisi"];
    $start_date = $decode["start_date"];
    $end_date = $decode["end_date"];

    $sql = "INSERT INTO positions (posisi, start_date, end_date) VALUES ('{$posisi}', '{$start_date}', '{$end_date}')";
    $run_sql = mysqli_query($conn, $sql);

    if($run_sql){
        echo json_encode(["success"=>true, "message"=>"Data Posisi Berhasil Dimasukkan"]);
    }else{
        echo json_encode(["success"=>false, "message"=>"Server Problem"]);
    }
    
?>