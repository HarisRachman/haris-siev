<?php
include "../../koneksi.php";

$sql = "SELECT votes.id as id, users.nama as voter, positions.posisi as posisi, 
        candidates.nama as kandidat, votes.voted_at as voted_at 
        FROM votes 
        LEFT JOIN users ON votes.user_id = users.id
        LEFT JOIN candidates ON votes.candidate_id = candidates.id
        LEFT JOIN positions ON candidates.position_id = positions.id
        ORDER BY id DESC";
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

?>