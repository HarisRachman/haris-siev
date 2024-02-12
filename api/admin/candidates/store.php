<?php
include '../../koneksi.php';

    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);

    $nama = $decode["nama"];
    $image = $decode["image"];
    $visi = $decode["visi"];
    $misi = $decode["misi"];
    $position_id = $decode["position_id"];

    $sql = "INSERT INTO candidates (nama, image, visi, misi, position_id) 
            VALUES ('{$nama}', '{$image}', '{$visi}', '{$misi}', '{$position_id}')";
    $run_sql = mysqli_query($conn, $sql);

    if($run_sql){
        echo json_encode(["success"=>true, "message"=>"Data Kandidat Berhasil Dimasukkan"]);
    }else{
        echo json_encode(["success"=>false, "message"=>"Server Problem"]);
    }

?>