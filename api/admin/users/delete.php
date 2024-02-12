<?php
include "../../koneksi.php";

$id = $_GET["id"];
$sql = "DELETE FROM users WHERE id = '{$id}'";
$run_sql = mysqli_query($conn,$sql);
if($run_sql){
    echo json_encode(["success"=>true, "message"=>"Data User Berhasil Dihapus"]);
}else{
    echo json_encode(["success"=>false, "message"=>"Server Problem"]);
}

?>