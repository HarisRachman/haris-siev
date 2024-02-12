<?php
include "../../koneksi.php";

$input = file_get_contents("php://input");
$decode = json_decode($input, true);

$id = $decode['id'];
$email = $decode["email"];
$nama = $decode["nama"];
$password = md5($decode["password"]);
$is_admin = '0';

$sql = "UPDATE users SET email = '{$email}', nama = '{$nama}', password = '{$password}' , is_admin = '{$is_admin}' WHERE id = '{$id}'";
$run_sql = mysqli_query($conn, $sql);

if($run_sql){
    echo json_encode(["success"=>true, "message"=>"Data User Berhasil Diubah"]);
}else{
    echo json_encode(["success"=>false, "message"=>"Server Problem"]);
}

?>