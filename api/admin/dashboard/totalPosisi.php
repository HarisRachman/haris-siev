<?php
include "../../koneksi.php";

$sql = "SELECT * FROM positions";
$run_sql = mysqli_query($conn, $sql);
$result = mysqli_num_rows($run_sql);

echo json_encode($result);

?>