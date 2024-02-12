<?php
include "../koneksi.php";

if(isset($_GET["user_id"]) && isset($_GET["position_id"])){
    $id_user = $_GET["user_id"];
    $id_posisi = $_GET["position_id"];
    $sql = "SELECT votes.user_id as user_id, candidates.position_id as position_id, votes.voted_at as voted_at
            FROM votes 
            LEFT JOIN candidates ON votes.candidate_id = candidates.id
            WHERE user_id = '{$id_user}'
            AND position_id = '{$id_posisi}'";
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