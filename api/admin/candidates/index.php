<?php
include "../../koneksi.php";

$sql = "SELECT candidates.id as id, candidates.nama as nama, candidates.image as image, 
        candidates.visi as visi, candidates.misi as misi, positions.posisi as posisi 
        FROM candidates 
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