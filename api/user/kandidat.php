<?php
include "../koneksi.php";

if(isset($_GET["position_id"])){
    $id = $_GET["position_id"];
    $sql = "SELECT * FROM candidates WHERE position_id = '{$id}'";
    $run_sql = mysqli_query($conn, $sql);
    $output = [];
    if (mysqli_num_rows($run_sql) > 0) {
        while($row = mysqli_fetch_assoc($run_sql)){
            $output[] = $row;
        }
    } else {
        $output["empty"] = "empty";
    }
    echo json_encode($output);
}

?>