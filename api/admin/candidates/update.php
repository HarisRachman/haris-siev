<?php
include "../../koneksi.php";

$input = file_get_contents("php://input");
$decode = json_decode($input, true);

$id = $decode['id'];
$nama = $decode["nama"];
$image = $decode["image"];
$visi = $decode["visi"];
$misi = $decode["misi"];
$position_id = $decode["position_id"];

$sql = "UPDATE candidates SET nama = '{$nama}', image = '{$image}', visi = '{$visi}', 
        misi = '{$misi}', position_id = '{$position_id}' WHERE id = '{$id}'";
$run_sql = mysqli_query($conn, $sql);

if($run_sql){
    echo json_encode(["success"=>true, "message"=>"Data Kandidat Berhasil Diubah"]);
}else{
    echo json_encode(["success"=>false, "message"=>"Server Problem"]);
}

?>