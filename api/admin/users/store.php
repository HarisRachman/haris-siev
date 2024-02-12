<?php
include '../../koneksi.php';

    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);

    $email = $decode["email"];
    $nama = $decode["nama"];
    $password = md5($decode["password"]);
    $is_admin = '0';

    $sql = "INSERT INTO users (email, nama, password, is_admin) VALUES ('{$email}', '{$nama}', '{$password}', '{$is_admin}')";
    $run_sql = mysqli_query($conn, $sql);

    if($run_sql){
        echo json_encode(["success"=>true, "message"=>"Data User Berhasil Dimasukkan"]);
    }else{
        echo json_encode(["success"=>false, "message"=>"Server Problem"]);
    }
    
?>