<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: ../../index.php');
} else {
    if($_SESSION['role'] == 0) {
        header('Location: ../user/votes.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SIeV</title>
        <link href="../assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">SIeV</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
                        <?php
                            if(isset($_SESSION['valid'])) {
                                echo $_SESSION['name'];
                            }
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li> -->
                        <li><a href="../../api/logout.php" onclick="return confirm('Are you sure you want to Log Out?')" class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link" href="users.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                User Data
                            </a>
                            <a class="nav-link" href="positions.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tag"></i></div>
                                Position Data
                            </a>
                            <a class="nav-link" href="candidates.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Candidate Data
                            </a>
                            <div class="sb-sidenav-menu-heading">Report</div>
                            <a class="nav-link" href="votes.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-check-to-slot"></i></div>
                                Votes
                            </a>
                            <a class="nav-link" href="chart.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                                Live Chart
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php
                            if(isset($_SESSION['valid'])) {
                                echo $_SESSION['name'];
                            }
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Charts</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Charts</li>
                        </ol>
                        <div id="printable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fas fa-check-to-slot me-1"></i>
                                    Live Chart
                                </div>
                                <div class="card-body">
                                    <div class="row" id="div_chart">
                                    <?php
                                    include("../../api/koneksi.php");
                                        $id = $_GET['id']; 
                                        $sql = "SELECT posisi FROM positions WHERE id = $id";
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<div class="col-7">
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <i class="fas fas fa-check-to-slot me-1"></i>
                                                            Perolehan Suara Pemilihan ' . $row["posisi"] . '
                                                        </div>
                                                        <div class="card-body">
                                                            <canvas id="myPieChart" width="400" height="400"></canvas>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }
                                        } else {
                                            echo '<div class="col-7">
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <i class="fas fas fa-check-to-slot me-1"></i>
                                                            Posisi
                                                        </div>
                                                        <div class="card-body">
                                                            <h6>Belum Ada Votes</h6>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    ?>

                                        <div class="col-5">
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <i class="fas fas fa-check-to-slot me-1"></i>
                                                    Detail Perolehan Suara
                                                </div>
                                                <div class="card-body" id="detail_vote">
                                                        
                                                <?php
                                                    include("../../api/koneksi.php");
                                                    $id = $_GET['id'];
                                                    $sql = "SELECT COUNT(votes.id) as vote, candidates.position_id as position_id, 
                                                            candidates.nama as kandidat, FORMAT(COUNT(votes.id) * 100.0 / (SELECT COUNT(votes.id) as total FROM votes), 2) as percentage,
                                                            (SELECT COUNT(*) FROM votes LEFT JOIN candidates ON votes.candidate_id = candidates.id WHERE candidates.position_id = '{$id}') AS total
                                                            FROM votes
                                                            LEFT JOIN candidates ON votes.candidate_id = candidates.id
                                                            WHERE candidates.position_id = '{$id}'
                                                            GROUP BY candidates.nama";

                                                    $result = $conn->query($sql);
                                                    
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '
                                                                <div class="card mb-3" style="padding:10px">
                                                                    <h4>'.$row["kandidat"].' ('.$row["percentage"].'%)</h4>
                                                                    <h5>Total Suara: </h5>
                                                                    <h5>'.$row["vote"].' dari '.$row["total"].' Suara</h5>
                                                                </div>
                                                            ';
                                                        }
                                                    } else {
                                                        echo '<h5>Belum Ada Vote</h5>';
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center><button class="btn btn-primary" onclick="printDiv('printable')">Print</button></center>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; SIeV 2024</div>
                            <!-- <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <!-- <script src="../assets/demo/chart-pie-demo.js"></script> -->
        <script>
            <?php
                include("../../api/koneksi.php");
                $id = $_GET['id'];
                $sql = "SELECT COUNT(votes.id) as vote, candidates.position_id as position_id, 
                        candidates.nama as kandidat 
                        FROM votes 
                        LEFT JOIN candidates ON votes.candidate_id = candidates.id
                        WHERE candidates.position_id = '{$id}'
                        GROUP BY candidates.nama";
                $result = $conn->query($sql);

                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                
                $conn->close();
            ?>
            
            // Format the data for Chart.js
            var labels = [];
            var data = [];
            <?php foreach ($data as $row): ?>
                labels.push("<?php echo $row['kandidat']; ?>");
                data.push("<?php echo $row['vote']; ?>");
            <?php endforeach; ?>
            
            // Create pie chart
            var ctx = document.getElementById('myPieChart').getContext('2d');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'right',
                        labels: {
                            fontSize: 14
                        }
                    },
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var label = data.labels[tooltipItem.index];
                                var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                    return parseInt(previousValue) + parseInt(currentValue);
                                });
                                var currentValue = dataset.data[tooltipItem.index];
                                var percent = Math.round((currentValue / total) * 100);
                                return label + ': ' + percent + '%';
                            }
                        }
                    }
                }
            });
        </script>
        <script>
            function printDiv(divId) {
                var opt = {
                    filename: 'chart.pdf',
                    margin: 0.1,
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
                };    
                var element = document.getElementById(divId);
                html2pdf()
                    .set(opt)
                    .from(element)
                    .save();
            }
        </script>
    </body>
</html>
